<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 21/01/19
 * Time: 01:38 م
 */

namespace SellerCenter\tests\Services;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use SellerCenter\Proxy\SellerCenterProxy as Proxy;
use Mockery as m;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\Request;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Services\ProductImageService;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductImageServiceTest extends TestCase
{
    /**
     * @dataProvider getProductImageTest
     *
     * @param Configuration $config
     * @param string        $xml
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function testCreateProducts(Configuration $config,string $xml)
    {
        $sellerCenterProxyMock = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')->andReturn([])->getMock();
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
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterRequest->setAction(Request::ACTION_IMAGE);
        $sellerCenterRequest->setBody($xml);
        $sellerCenterProxyMock->shouldReceive('getResponse',[$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $productService = new ProductImageService($sellerCenterProxyMock,$this->createMock(ValidatorInterface::class));
        $response = $productService->createImages($config,$xml);
        $this->assertInternalType('array',$response->getBody());
    }

    public function getProductImageTest() {
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
                'abcdc'
            ]
        ];
    }


}