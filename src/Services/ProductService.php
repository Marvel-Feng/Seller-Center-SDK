<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 14/01/19
 * Time: 01:16 م
 */

namespace SellerCenter\Services;

use GuzzleHttp\Exception\GuzzleException;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\Product;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Model\Request;
use SellerCenter\Proxy\SellerCenterProxy;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductService
{
    const STARTING_OFFSET = 0;
    const LIMIT           = 5000;

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
     * @param string        $xml
     *
     * @return SuccessResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function createProducts(Configuration $account, string $xml): SuccessResponse
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION => Request::ACTION_PRODUCT_CREATE,
            ]
        );
        $sellerCenterRequest->setHeaders(
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        );
        $sellerCenterRequest->setAction(Request::ACTION_PRODUCT_CREATE);
        $sellerCenterRequest->setBody($xml);
        $sellerCenterRequest->addConfiguration($account);

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest);
    }

    /**
     * @param Configuration $account
     * @param array         $data
     *
     * @return Product[]
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function getProducts(Configuration $account, array $data): array
    {
        $sellerCenterRequest = new Request();
        $requestParameters   = [];
        if (!empty($data['SKUs'])) {
            $requestParameters[Request::QUERY_PARAMETER_SKU_SELLER_LIST] = serialize($data['SKUs']);
            $requestParameters[Request::QUERY_PARAMETER_LIMIT]           = $limit ?? sizeof($data['SKUs']);
            if (isset($data['offset'])) {
                $requestParameters[Request::QUERY_PARAMETER_OFFSET] = $data['offset'];
            }
        } elseif (isset($data['limit'])) {
            $requestParameters[Request::QUERY_PARAMETER_LIMIT] = $data['limit'];
            if (isset($data['offset'])) {
                $requestParameters[Request::QUERY_PARAMETER_OFFSET] = $data['offset'];
            }
        }
        if (isset($data['filter']) && in_array($data['filter'], Product::SELLER_CENTER_PRODUCT_STATES_ARRAY)) {
            $requestParameters[Request::QUERY_PARAMETER_FILTER] = $data['filter'];
        }
        if (isset($data['updatedBefore'])) {
            $requestParameters[Request::QUERY_PARAMETER_UPDATED_BEFORE] = $data['updatedBefore'];
        }
        if (isset($data['createdAfter'])) {
            $requestParameters[Request::QUERY_PARAMETER_CREATED_AFTER] = $data['createdAfter'];
        }
        $sellerCenterRequest->setAction(Request::ACTION_GET_PRODUCTS);
        $sellerCenterRequest->setParameters($requestParameters);
        $sellerCenterRequest->addConfiguration($account);

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest)->getBody();
    }

    /**
     * @param Configuration $account
     * @param string        $xml
     *
     * @return SuccessResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function updateProducts(Configuration $account, string $xml): SuccessResponse
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION => Request::ACTION_PRODUCT_UPDATE,
            ]
        );
        $sellerCenterRequest->setAction(Request::ACTION_PRODUCT_UPDATE);
        $sellerCenterRequest->setBody($xml);
        $sellerCenterRequest->addConfiguration($account);

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest);
    }
}
