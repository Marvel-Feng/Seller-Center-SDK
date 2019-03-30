<?php

namespace SellerCenter\Handler;

use DOMDocument;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Factory\ResponseGeneratorFactory;
use SellerCenter\Http\Client;
use SellerCenter\Model\Request;
use SellerCenter\Model\ResponseHead;
use SellerCenter\Model\SuccessResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class ResponseHandler
{
    // Response Keys
    const SUCCESS_RESPONSE_KEY        = 'SuccessResponse';
    const BODY_RESPONSE_KEY           = 'Body';
    const ATTRIBUTE_KEY               = 'Attribute';
    const HEAD_RESPONSE_KEY           = 'Head';
    const REQUEST_ID_RESPONSE_KEY     = 'RequestId';
    const TIME_STAMP_RESPONSE_KEY     = 'Timestamp';
    const PRODUCTS_RESPONSE_KEY       = 'Products';
    const PRODUCT_RESPONSE_KEY        = 'Product';
    const REQUEST_ACTION_RESPONSE_KEY = 'RequestAction';
    const ERROR_RESPONSE_KEY          = 'ErrorResponse';
    const ERROR_TYPE_RESPONSE_KEY     = 'ErrorType';
    const ERROR_CODE_RESPONSE_KEY     = 'ErrorCode';
    const ERROR_MESSAGE_RESPONSE_KEY  = 'ErrorMessage';
    /** Global Errors Status Codes */
    const MISSING_PARAMETER_CODE               = 1;
    const INVALID_VERSION_CODE                 = 2;
    const INVALID_VERSION_CODE_2               = 0;
    const TIME_STAMP_EXPIRED_CODE              = 3;
    const INVALID_TIME_STAMP_FORMAT_CODE       = 4;
    const INVALID_REQUEST_FORMAT_CODE          = 5;
    const INTERNAL_ERROR_CODE                  = 6;
    const LOGIN_FAILED_SIGNATURE_MISMATCH_CODE = 7;
    const INVALID_ACTION_CODE                  = 8;
    const ACCESS_DENIED_CODE                   = 9;
    const INSECURE_CHANNEL_CODE                = 10;
    const REQUEST_TOO_BIG_CODE                 = 11;
    const INVALID_FEED_ID_ERROR_CODE           = 12;
    const TOO_MANY_REQUESTS_CODE               = 429;
    const INTERNAl_APPLICATION_ERROR_CODE      = 1000;
    const EMPTY_REQUEST_ERROR_CODE             = 30;
    /** Break List */
    const BREAK_LIST
        = [
            self::MISSING_PARAMETER_CODE,
            self::INVALID_VERSION_CODE,
            self::INVALID_TIME_STAMP_FORMAT_CODE,
            self::INVALID_REQUEST_FORMAT_CODE,
            self::LOGIN_FAILED_SIGNATURE_MISMATCH_CODE,
            self::INVALID_FEED_ID_ERROR_CODE,
            self::EMPTY_REQUEST_ERROR_CODE,
            self::INVALID_ACTION_CODE,
            self::INVALID_VERSION_CODE_2,
        ];
    /** @var LoggerInterface $loggerInterface */
    private $loggerInterface;

    /** @var ResponseGeneratorFactory $generatorFactory */
    private $generatorFactory;

    /**
     * ExceptionHandler constructor.
     *
     * @param LoggerInterface          $loggerInterface
     * @param ResponseGeneratorFactory $generatorFactory
     */
    public function __construct(LoggerInterface $loggerInterface, ResponseGeneratorFactory $generatorFactory)
    {
        $this->loggerInterface  = $loggerInterface;
        $this->generatorFactory = $generatorFactory;
    }

    /**
     * @param Request               $sellerCenterRequest
     * @param SellerCenterException $exception
     * @param                       $attemptsCount
     */
    public function emergencyLog(
        Request $sellerCenterRequest,
        SellerCenterException $exception,
        $attemptsCount
    ) {
        $logContext = [
            'exceptionMessage'  => $exception->getMessage(),
            'attemptsThreshold' => Client::REQUEST_ATTEMPTS_THRESHOLD,
            'attemptsCount'     => $attemptsCount,
            'attemptDelayLimit' => Client::$MAX_ATTEMPTS_DELAY,
            'parameters'        => $sellerCenterRequest->getParameters(),
            'headers'           => $sellerCenterRequest->getHeaders(),
            'method'            => $sellerCenterRequest->getMethod(),
            'uri'               => $sellerCenterRequest->getUrl(),
            'body'              => $sellerCenterRequest->getBody(),
        ];
        $action     = $sellerCenterRequest->getAction();
        $statusCode = $exception->getCode();
        $this->loggerInterface->emergency(
            "SellerCenter Request Exited For $action\nStatus Code: $statusCode",
            $logContext
        );
    }

    /**
     * @param array $response
     *
     * @return SuccessResponse
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    public function generateSellerCenterSuccessResponse(array $response): SuccessResponse
    {
        $responseHead = SuccessResponse::SC_SUCCESS_RESPONSE.'.'
            .SuccessResponse::SC_RESPONSE_HEAD;

        $responseType = array_get($response, "$responseHead.".ResponseHead::SC_HEAD_RESPONSE_TYPE);

        $generator = $this->generatorFactory->make(
            $responseType
        );

        return $generator->makeResponse($response);
    }

    /**
     * @param int $statusCode
     *
     * @return bool
     */
    public function isBreakCase(int $statusCode): bool
    {
        return (array_search($statusCode, self::BREAK_LIST) == false) ? false : true;
    }

    /**
     * @param mixed|\Psr\Http\Message\ResponseInterface $response
     * @param string                                    $responseBody
     *
     * @return bool
     */
    public function isSuccessResponse($response, string $responseBody)
    {
        $responseFormat = $response->getHeaders()['Content-Type'][0];
        if ($responseFormat == 'application/json') {
            return array_key_exists(self::SUCCESS_RESPONSE_KEY, json_decode($responseBody, true));
        } elseif ($responseFormat == 'application/xml' || $responseFormat == 'text/xml; charset=utf-8') {
            $dom = new DOMDocument();
            $dom->loadXML($responseBody);
            $successNode = $dom->getElementsByTagName(self::SUCCESS_RESPONSE_KEY);

            return $successNode->length > 0;
        } else {
            $this->loggerInterface->warning(
                'Unknown response body format received from SellerCenter',
                [
                    'responseFormat' => $responseFormat,
                    'responseBody'   => $responseBody,
                ]
            );

            return $response->getStatusCode() == Response::HTTP_OK;
        }
    }


}