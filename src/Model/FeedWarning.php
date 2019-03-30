<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 17/01/19
 * Time: 12:27 م
 */

namespace SellerCenter\Model;

class FeedWarning
{
    /** @var string $message */
    protected $message ;

    /** @var string $sellerSku */
    protected $sellerSku;

    /**
     * FeedWarning constructor.
     *
     * @param string $message
     * @param string $sellerSku
     */
    public function __construct(string $message, string $sellerSku)
    {
        $this->message   = $message;
        $this->sellerSku = $sellerSku;
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
}