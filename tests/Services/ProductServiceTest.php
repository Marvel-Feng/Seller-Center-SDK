<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 14/01/19
 * Time: 04:08 م
 */

namespace SellerCenter\tests\Services;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use SellerCenter\Proxy\SellerCenterProxy as Proxy;
use Mockery as m;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\Product;
use SellerCenter\Model\Request;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Services\ProductService;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductServiceTest extends TestCase
{
    /**
     * @dataProvider createProductsTestCases
     *
     * @param Configuration $config
     * @param string        $xml
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @throws \ReflectionException
     */
    public function testCreateProducts(Configuration $config, string $xml)
    {
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')
            ->andReturn([])
            ->getMock();
        $sellerCenterRequest         = new Request();
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
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterRequest->setBody($xml);
        $sellerCenterRequest->setAction(Request::ACTION_PRODUCT_CREATE);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);

        $productService = new ProductService();

        $reflection = new \ReflectionClass($productService);
        $property = $reflection->getProperty('sellerCenterProxy');
        $property->setAccessible(true);
        $property->setValue($productService,$sellerCenterProxyMock);

        $response       = $productService->createProducts($config, $xml);
        $this->assertInternalType('array', $response->getBody());
    }

    /**
     * @param array $data
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @throws \ReflectionException
     * @dataProvider getProductsTestCases
     */
    public function testGetProducts(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')
            ->andReturn([new Product()])
            ->getMock();
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_LIMIT           => $data[Request::QUERY_PARAMETER_LIMIT] ?? null,
            Request::QUERY_PARAMETER_SKU_SELLER_LIST => $data[Request::QUERY_PARAMETER_SKU_SELLER_LIST] ?? null,
            Request::QUERY_PARAMETER_OFFSET          => $data[Request::QUERY_PARAMETER_OFFSET],
            Request::QUERY_PARAMETER_ACTION          => $data[Request::QUERY_PARAMETER_ACTION],
            Request::QUERY_PARAMETER_FILTER          => $data[Request::QUERY_PARAMETER_FILTER],
            Request::QUERY_PARAMETER_CREATED_AFTER   => $data[Request::QUERY_PARAMETER_CREATED_AFTER],
            Request::QUERY_PARAMETER_UPDATED_BEFORE  => $data[Request::QUERY_PARAMETER_UPDATED_BEFORE],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $productService = new ProductService();

        $reflection = new \ReflectionClass($productService);
        $property = $reflection->getProperty('sellerCenterProxy');
        $property->setAccessible(true);
        $property->setValue($productService,$sellerCenterProxyMock);
        $response       = $productService->getProducts(
            $config,
            [
                'SKUs'          => $data[Request::QUERY_PARAMETER_SKU_SELLER_LIST] ?? null,
                'limit'         => $data[Request::QUERY_PARAMETER_LIMIT] ?? null,
                'offset'        => $data[Request::QUERY_PARAMETER_OFFSET],
                'filter'        => $data[Request::QUERY_PARAMETER_FILTER],
                'createdAfter'  => $data[Request::QUERY_PARAMETER_CREATED_AFTER],
                'updatedBefore' => $data[Request::QUERY_PARAMETER_UPDATED_BEFORE],
            ]
        );
        $this->assertInternalType('array', $response);
    }

    /**
     * @dataProvider createProductsTestCases
     *
     * @param Configuration $config
     * @param string        $xml
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @throws \ReflectionException
     */
    public function testUpdateProducts(Configuration $config, string $xml)
    {
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')
            ->andReturn([])
            ->getMock();
        $sellerCenterRequest         = new Request();
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION => Request::ACTION_PRODUCT_UPDATE,
            ]
        );
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterRequest->setBody($xml);
        $sellerCenterRequest->setAction(Request::ACTION_PRODUCT_UPDATE);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $productService = new ProductService();

        $reflection = new \ReflectionClass($productService);
        $property = $reflection->getProperty('sellerCenterProxy');
        $property->setAccessible(true);
        $property->setValue($productService,$sellerCenterProxyMock);
        $response       = $productService->updateProducts($config, $xml);
        $this->assertInternalType('array', $response->getBody());
    }

    public function createProductsTestCases()
    {
        $validRequest = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
        $configuration = new Configuration(
          $validRequest['url'],
          $validRequest['email'],
          $validRequest['apiKey'],
          $validRequest['apiPassword'],
          $validRequest['username'],
          $validRequest['version']
        );
        return [
            [
                $configuration,
                'abcdc',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getProductsTestCases()
    {
        $validRequest = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
        $configuration = new Configuration(
            $validRequest['url'],
            $validRequest['email'],
            $validRequest['apiKey'],
            $validRequest['apiPassword'],
            $validRequest['username'],
            $validRequest['version']
        );
        return [
            [
                [
                    'configuration'                                  => $configuration,
                    Request::QUERY_PARAMETER_SKU_SELLER_LIST => ['A', 'B'],
                    Request::QUERY_PARAMETER_OFFSET          => 1,
                    Request::QUERY_PARAMETER_ACTION          => Request::ACTION_GET_PRODUCTS,
                    Request::QUERY_PARAMETER_FILTER          => Product::SC_PRODUCT_STATE_LIVE,
                    Request::QUERY_PARAMETER_CREATED_AFTER   => 1,
                    Request::QUERY_PARAMETER_UPDATED_BEFORE  => 2,
                ],
                [
                    'configuration'                                  => $configuration,
                    Request::QUERY_PARAMETER_LIMIT          => 100,
                    Request::QUERY_PARAMETER_OFFSET         => 1,
                    Request::QUERY_PARAMETER_ACTION         => Request::ACTION_GET_PRODUCTS,
                    Request::QUERY_PARAMETER_FILTER         => Product::SC_PRODUCT_STATE_LIVE,
                    Request::QUERY_PARAMETER_CREATED_AFTER  => 1,
                    Request::QUERY_PARAMETER_UPDATED_BEFORE => 2,
                ],
            ],
        ];
    }


}