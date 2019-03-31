<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 17/01/19
 * Time: 03:18 م
 */

namespace SellerCenter\tests\Services;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use SellerCenter\Proxy\SellerCenterProxy as Proxy;
use Mockery as m;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Model\CategoryAttribute;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\Request;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Services\CategoryAttributeService;

class CategoryAttributeServiceTest extends TestCase
{
    /**
     * @return array
     */
    public function getCategoryAttributesTestCases()
    {
        $validRequest  = json_decode(
            file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'),
            true
        );
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
                    'configuration'                           => $configuration,
                    Request::QUERY_PARAMETER_ACTION           => Request::ACTION_GET_CATEGORY_ATTRIBUTES,
                    Request::QUERY_PARAMETER_PRIMARY_CATEGORY => '111',
                ],
            ],
        ];
    }

    /**
     * @param array $data
     *
     * @throws SellerCenterException
     * @throws GuzzleException
     * @throws \ReflectionException
     * @dataProvider getCategoryAttributesTestCases
     */
    public function testGetCategoryAttributes(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')
            ->andReturn([new CategoryAttribute()])
            ->getMock();
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION           => $data[Request::QUERY_PARAMETER_ACTION],
            Request::QUERY_PARAMETER_PRIMARY_CATEGORY => $data[Request::QUERY_PARAMETER_PRIMARY_CATEGORY],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $categoryService = new CategoryAttributeService();
        $reflection = new \ReflectionClass($categoryService);
        $property = $reflection->getProperty('sellerCenterProxy');
        $property->setAccessible(true);
        $property->setValue($categoryService,$sellerCenterProxyMock);
        $response        = $categoryService->getCategoryAttributes(
            $config,
            $data[Request::QUERY_PARAMETER_PRIMARY_CATEGORY]
        );
        $this->assertInternalType('array', $response);
    }

}