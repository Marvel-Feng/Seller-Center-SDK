<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 15/01/19
 * Time: 02:19 م
 */

namespace SellerCenter\Services;

use GuzzleHttp\Exception\GuzzleException;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\Request;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Proxy\SellerCenterProxy;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductImageService
{
    /** @var SellerCenterProxy $sellerCenterProxy */
    protected $sellerCenterProxy;

    /** @var ValidatorInterface $validator */
    protected $validator;

    /**
     * SellerCenterService constructor.
     *
     * @param SellerCenterProxy  $sellerCenterProxy
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SellerCenterProxy $sellerCenterProxy,
        ValidatorInterface $validator
    ) {
        $this->sellerCenterProxy = $sellerCenterProxy;
        $this->validator         = $validator;
    }

    /**
     * @param Configuration $account
     * @param string        $images
     *
     * @return SuccessResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function createImages(Configuration $account, string $images): SuccessResponse
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION => Request::ACTION_IMAGE,
            ]
        );
        $sellerCenterRequest->setHeaders(
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        );
        $sellerCenterRequest->setAction(Request::ACTION_IMAGE);
        $sellerCenterRequest->setBody($images);
        $sellerCenterRequest->addConfiguration($account);

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest);
    }
}