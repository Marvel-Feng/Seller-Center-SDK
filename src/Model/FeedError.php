<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 17/01/19
 * Time: 12:52 م
 */

namespace SellerCenter\Model;

class FeedError
{
    /** @var string $message */
    protected $message ;

    /** @var string $sellerSku */
    protected $sellerSku;

    /** @var string code */
    protected $code;

    /**
     * FeedError constructor.
     *
     * @param string $message
     * @param string $sellerSku
     * @param string $code
     */
    public function __construct(string $message, string $sellerSku, string $code)
    {
        $this->message   = $message;
        $this->sellerSku = $sellerSku;
        $this->code      = $code;
    }


    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getSellerSku(): string
    {
        return $this->sellerSku;
    }

    /**
     * @param string $sellerSku
     */
    public function setSellerSku(string $sellerSku): void
    {
        $this->sellerSku = $sellerSku;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

}