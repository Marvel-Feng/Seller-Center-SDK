<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 13/01/19
 * Time: 01:22 م
 */

namespace SellerCenter\Model;

class SuccessResponse
{
    const SC_SUCCESS_RESPONSE = 'SuccessResponse';
    const SC_RESPONSE_HEAD    = 'Head';
    const SC_RESPONSE_BODY    = 'Body';

    /** @var ResponseHead $head */
    protected $head;

    /** @var Product[]|FeedStatus[]|CategoryAttribute[]|Order[]|OrderItem[] $body */
    protected $body;

    /**
     * @return Product[]|FeedStatus|CategoryAttribute[]|Order[]|OrderItem[]
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param Product[]|FeedStatus|CategoryAttribute[]|Order[]|OrderItem[] $body
     *
     * @return SuccessResponse
     */
    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return ResponseHead
     */
    public function getHead(): ResponseHead
    {
        return $this->head;
    }

    /**
     * @param ResponseHead $head
     *
     * @return SuccessResponse
     */
    public function setHead(ResponseHead $head): self
    {
        $this->head = $head;

        return $this;
    }

}