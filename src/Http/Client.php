<?php

namespace SellerCenter\Http;

use Exception;
use Illuminate\Support\Arr;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Handler\ResponseHandler;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\Request;
use DateTime;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Symfony\Component\HttpFoundation\Response;

class Client
{

    // Query parameter namings
    const QUERY_PARAMETER_ACTION    = 'Action';
    const QUERY_PARAMETER_VERSION   = 'Version';
    const QUERY_PARAMETER_TIMESTAMP = 'Timestamp';
    const QUERY_PARAMETER_USER_ID   = 'UserID';
    const QUERY_PARAMETER_SIGNATURE = 'Signature';
    const QUERY_PARAMETER_FORMAT    = 'Format';

    // Request Format
    const FORMAT_JSON                = 'JSON';
    const FORMAT_XML                 = 'XML';
    const DEFAULT_FORMAT             = self::FORMAT_JSON;
    const REQUEST_ATTEMPTS_THRESHOLD = 10;
    const ERROR_RESPONSE             = 'ErrorResponse';
    const ERROR_RESPONSE_HEAD        = 'Head';

    // Error Data
    const ERROR_RESPONSE_ERROR_CODE    = 'ErrorCode';
    const ERROR_RESPONSE_ERROR_MESSAGE = 'ErrorMessage';

    const MAX_ATTEMPTS_DELAY           = 5;
    const MIN_ATTEMPTS_DELAY           = 1;

    /** @var Client $httpClient */
    private $httpClient;

    /** @var ResponseHandler $responseHandler */
    private $responseHandler;

    public function __construct()
    {
        $this->httpClient      = new GuzzleClient();
        $this->responseHandler = new ResponseHandler();
    }

    /**
     * @param Request $sellerCenterRequest
     *
     * @return mixed
     * @throws GuzzleException
     * @throws Exception
     */
    public function request(Request $sellerCenterRequest): GuzzleResponse
    {
        $options  = $this->getRequestOptions($sellerCenterRequest);
        $response = $this->httpClient->request(
            $sellerCenterRequest->getMethod(),
            $sellerCenterRequest->getUrl(),
            $options
        );
        if ($response->getBody()->eof()) {
            $response->getBody()
                ->rewind();
        }

        return $response;
    }

    /**
     * @param Configuration $configuration
     * @param Request       $sellerCenterRequest
     *
     * @return GuzzleResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function sendSellerCenterRequest(Configuration $configuration, Request $sellerCenterRequest): GuzzleResponse
    {
        $response         = null;
        $errorMsg         = null;
        $errorCode        = null;
        $attemptsCount    = 0;
        $response404Count = 0;
        $breakCase        = false;
        while (!$breakCase && $attemptsCount < $configuration->getRequestAttemptsThreshold() && $response404Count < 2) {
            $attemptsCount++;
            try {
                $response          = $this->request($sellerCenterRequest);
                $responseJson      = json_decode(
                    $response->getBody()
                        ->getContents(),
                    true
                );
                $errorResponseHead = Arr::get(
                    $responseJson,
                    self::ERROR_RESPONSE.'.'.self::ERROR_RESPONSE_HEAD,
                    false
                );
                if ($errorResponseHead) {
                    $errorCode = (int)$errorResponseHead[self::ERROR_RESPONSE_ERROR_CODE];
                    $errorMsg  = $errorResponseHead[self::ERROR_RESPONSE_ERROR_MESSAGE];
                    $breakCase = $this->responseHandler->isBreakCase($errorCode);
                    if (!$breakCase) {
                        $response = null;
                    }
                } else {
                    $response->getBody()
                        ->rewind();
                    break;
                }

            } catch (BadResponseException $exception) {
                if ($exception->hasResponse() && $exception->getResponse() != null) {
                    $response           = $exception->getResponse();
                    $responseContents   = $response->getBody()
                        ->getContents();
                    $responseStatusCode = $exception->getResponse()
                        ->getStatusCode();
                    if ($this->responseHandler->isSuccessResponse($response, $responseContents)) {
                        $response->getBody()
                            ->rewind();
                        break;
                    } else {
                        $response = null;
                        // @todo log error message
                        $errorCode = $exception->getCode();
                        $errorMsg  = $exception->getMessage();
                    }
                    $response404Count += ($responseStatusCode == Response::HTTP_NOT_FOUND);
                }
                sleep(rand($configuration->getMinAttemptsDelay(), $configuration->getMaxAttemptsDelay()));
            }
        }
        if (isset($response) && !$breakCase) {
            return $response;
        } else {
            $exception = new SellerCenterException($errorMsg, $errorCode, $sellerCenterRequest->getAction());
            if ($configuration->isLoggingEnabled()) {
                $this->responseHandler->emergencyLog($configuration, $sellerCenterRequest, $exception, $attemptsCount);
            }
            throw $exception;
        }
    }

    /**
     * @param Request $sellerCenterRequest
     *
     * @return array
     * @throws Exception
     */
    private function getRequestOptions(Request $sellerCenterRequest): array
    {
        $options = [
            'query' => $this->getSignedParameters($sellerCenterRequest),
        ];
        if ($sellerCenterRequest->getBody()) {
            $options['body'] = $sellerCenterRequest->getBody();
        }
        if (!empty($sellerCenterRequest->getHeaders())) {
            $options['headers'] = $sellerCenterRequest->getHeaders();
        }
        $options['auth'] = [$sellerCenterRequest->getUsername(), $sellerCenterRequest->getPassword()];

        return $options;
    }

    /**
     * @param Request $sellerCenterRequest
     *
     * @return array
     * @throws Exception
     */
    private function getSignedParameters(Request $sellerCenterRequest): array
    {
        date_default_timezone_set("UTC");
        $now                                         = new DateTime();
        $parameters                                  = $sellerCenterRequest->getParameters();
        $parameters[self::QUERY_PARAMETER_ACTION]    = $sellerCenterRequest->getAction();
        $parameters[self::QUERY_PARAMETER_USER_ID]   = $sellerCenterRequest->getUserId();
        $parameters[self::QUERY_PARAMETER_VERSION]   = $sellerCenterRequest->getVersion();
        $parameters[self::QUERY_PARAMETER_TIMESTAMP] = $now->format(DateTime::ISO8601);
        $parameters[self::QUERY_PARAMETER_FORMAT]    = $parameters[self::QUERY_PARAMETER_FORMAT] ?? self::DEFAULT_FORMAT;
        ksort($parameters);
        $encoded = [];
        foreach ($parameters as $name => $value) {
            $encoded[] = rawurlencode($name).'='.rawurlencode($value);
        }
        $concatenated                                = implode('&', $encoded);
        $parameters[self::QUERY_PARAMETER_SIGNATURE] = rawurlencode(
            hash_hmac('sha256', $concatenated, $sellerCenterRequest->getApiKey(), false)
        );

        return $parameters;
    }

}