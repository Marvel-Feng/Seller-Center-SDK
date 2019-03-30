<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 15/01/19
 * Time: 02:02 م
 */

namespace SellerCenter\Services;

use GuzzleHttp\Exception\GuzzleException;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\CategoryAttribute;
use SellerCenter\Model\Request;
use SellerCenter\Proxy\SellerCenterProxy;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryAttributeService
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
        $this->sellerCenterProxy   = $sellerCenterProxy;
        $this->validator           = $validator;
    }

    /**
     * @param Configuration $account
     * @param int           $categoryId
     *
     * @return CategoryAttribute[] array
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function getCategoryAttributes(Configuration $account,int $categoryId): array
    {
        $sellerCenterRequest = new Request();

        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION           => Request::ACTION_GET_CATEGORY_ATTRIBUTES,
                Request::QUERY_PARAMETER_PRIMARY_CATEGORY => $categoryId,
            ]
        );
        $sellerCenterRequest->setAction(Request::ACTION_GET_CATEGORY_ATTRIBUTES);
        $sellerCenterRequest->addConfiguration($account);
        return $this->sellerCenterProxy->getResponse($sellerCenterRequest)->getBody();
    }
}