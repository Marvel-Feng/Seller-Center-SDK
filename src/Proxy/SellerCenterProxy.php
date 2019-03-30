<?php

namespace SellerCenter\Proxy;

use SellerCenter\Handler\ResponseHandler;
use SellerCenter\Http\Client;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Model\Request;

class SellerCenterProxy
{
    /** @var Client $sellerCenterClient */
    private $sellerCenterClient;

    /** @var ResponseHandler $responseHandler */
    private $responseHandler;

    /**
     * SellerCenterProxy constructor.
     *
     * @param Client          $sellerCenterClient
     * @param ResponseHandler $responseHandler
     */
    public function __construct(Client $sellerCenterClient, ResponseHandler $responseHandler)
    {
        $this->sellerCenterClient = $sellerCenterClient;
        $this->responseHandler    = $responseHandler;
    }

    /**
     * @param Request $sellerCenterRequest
     *
     * @return SuccessResponse
     * @throws \SellerCenter\Exception\SellerCenterException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function getResponse(Request $sellerCenterRequest): SuccessResponse
    {
        $jsonResponse = json_decode($this->sellerCenterClient->sendSellerCenterRequest($sellerCenterRequest)->getBody(),true);
        return $this->responseHandler->generateSellerCenterSuccessResponse($jsonResponse);
    }

}