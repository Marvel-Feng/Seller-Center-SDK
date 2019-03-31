<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 13/01/19
 * Time: 05:11 م
 */

namespace SellerCenter\Generator;

use Illuminate\Support\Arr;
use SellerCenter\Hydrator\Hydrator;
use SellerCenter\Model\Order;
use SellerCenter\Model\OrderItem;
use SellerCenter\Model\CategoryAttribute;
use SellerCenter\Model\FeedStatus;
use SellerCenter\Model\Product;
use SellerCenter\Model\ResponseHead;
use SellerCenter\Model\SuccessResponse;

abstract class ResponseGenerator
{
    /** @var Hydrator $hydrator */
    protected $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @param array $body
     *
     * @return Product[]|FeedStatus|CategoryAttribute[]|Order[]|OrderItem[]
     */
    protected abstract function makeBody(array $body);

    /**
     * @param array $head
     *
     * @return ResponseHead
     * @throws \Exception
     */
    protected function makeHead(array $head): ResponseHead
    {
        return new ResponseHead(
            Arr::get($head, ResponseHead::SC_HEAD_REQUEST_ID),
            Arr::get($head, ResponseHead::SC_HEAD_REQUEST_ACTION),
            Arr::get($head, ResponseHead::SC_HEAD_RESPONSE_TYPE),
            new \DateTime(Arr::get($head, ResponseHead::SC_HEAD_RESPONSE_TIMESTAMP))
        );
    }

    /**
     * @param array $response
     *
     * @return SuccessResponse
     * @throws \Exception
     */
    public function makeResponse(
        array $response
    ): SuccessResponse {

        $responseHead = SuccessResponse::SC_SUCCESS_RESPONSE.'.'
            .SuccessResponse::SC_RESPONSE_HEAD;

        $responseBody = SuccessResponse::SC_SUCCESS_RESPONSE.'.'
            .SuccessResponse::SC_RESPONSE_BODY;

        $head = Arr::get($response, $responseHead, []);
        $body = Arr::get($response, $responseBody, []);

        return (new SuccessResponse())
            ->setBody(
                $this->makeBody($body)
            )->setHead(
                $this->makeHead($head)
            );
    }

    /**
     * @param $object
     *
     * @return array
     */
    public static function to2DArrayIfNot($object)
    {
        return (is_array(current($object))) ? $object : [$object];
    }
}