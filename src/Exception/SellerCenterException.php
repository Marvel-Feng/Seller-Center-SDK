<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 06/01/19
 * Time: 02:22 م
 */

namespace SellerCenter\Exception;


class SellerCenterException extends \Exception
{
    const UNEXPECTED_INTERNAL_ERROR = 6 ;
    const TOO_MANY_REQUESTS = 429;
    const INTERNAL_APPLICATION_ERROR = 1000 ;
    const REQUEUE_CODE = [
        self::UNEXPECTED_INTERNAL_ERROR,
        self::TOO_MANY_REQUESTS,
        self::INTERNAL_APPLICATION_ERROR
    ];
    /** @var string $action */
    protected $action;

    public function __construct($message = "", $code = 0,string $action = '')
    {
        parent::__construct($message, $code);
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }


}