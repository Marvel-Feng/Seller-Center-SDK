<?php

namespace SellerCenter\Proxy;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Handler\ResponseHandler;
use SellerCenter\Http\Client;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Model\Request;

class SellerCenterProxy
{
    /** @var Client $sellerCenterClient */
    private $sellerCenterClient;

    /** @var ResponseHandler $responseHandler */
    private $responseHandler;

    public function __construct()
    {
        $this->sellerCenterClient = new Client();
        $this->responseHandler    = new ResponseHandler();
    }

    /**
     * @param Configuration $configuration
     * @param Request       $sellerCenterRequest
     *
     * @return SuccessResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     * @throws Exception
     */
    public function getResponse(Configuration $configuration, Request $sellerCenterRequest): SuccessResponse
    {
        $jsonResponse = json_decode(
            $this->sellerCenterClient->sendSellerCenterRequest($configuration, $sellerCenterRequest)->getBody(),
            true
        );

        return $this->responseHandler->generateSellerCenterSuccessResponse($jsonResponse);
    }

}