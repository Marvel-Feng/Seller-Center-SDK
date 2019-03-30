<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 13/01/19
 * Time: 01:26 م
 */

namespace SellerCenter\Model;

class ResponseHead
{
    const SC_HEAD_REQUEST_ID    = 'RequestId';
    const SC_HEAD_REQUEST_ACTION    = 'RequestAction';
    const SC_HEAD_RESPONSE_TYPE   = 'ResponseType';
    const SC_HEAD_RESPONSE_TIMESTAMP  = 'Timestamp';

    /** @var string $requestId */
    public $requestId;

    /** @var string $requestAction */
    public $requestAction;

    /** @var string $responseType */
    public $responseType;

    /** @var \DateTime $timestamp */
    public $timestamp;

    /**
     * ResponseHead constructor.
     *
     * @param string    $requestId
     * @param string    $requestAction
     * @param string    $responseType
     * @param \DateTime $timestamp
     */
    public function __construct(string $requestId, string $requestAction, string $responseType, \DateTime $timestamp)
    {
        $this->requestId     = $requestId;
        $this->requestAction = $requestAction;
        $this->responseType  = $responseType;
        $this->timestamp     = $timestamp;
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getRequestAction(): string
    {
        return $this->requestAction;
    }

    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return $this->responseType;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }



}