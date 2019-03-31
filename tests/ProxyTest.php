<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 21/01/19
 * Time: 01:46 م
 */

namespace SellerCenter\tests;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Handler\ResponseHandler;
use SellerCenter\Http\Client;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\Request;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Proxy\SellerCenterProxy;
use GuzzleHttp\Psr7\Response;
use Mockery as m;

class ProxyTest extends TestCase
{
    /** @var ResponseHandler $responseHandler */
    private $responseHandler;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct(
            $name,
            $data,
            $dataName
        );
        $this->responseHandler = new ResponseHandler();
    }

    public function getResponseTestCases()
    {
        $products = json_decode(file_get_contents(__DIR__.'/HydratorTest/products.json'), true);

        return [
            [
                json_encode($products['test1']),
            ],
        ];
    }

    /**
     * @param string $jsonBody
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @throws \ReflectionException
     * @dataProvider getResponseTestCases
     */
    public function testGetResponse(string $jsonBody)
    {
        $client = m::mock(Client::class)
            ->allows('sendSellerCenterRequest')
            ->andReturn(
                new Response(200, [], $jsonBody)
            )
            ->getMock();
        $proxyService      = new SellerCenterProxy();
        $reflection = new \ReflectionClass($proxyService);
        $property = $reflection->getProperty('sellerCenterClient');
        $property->setAccessible(true);
        $property->setValue($proxyService,$client);
        $response          = $proxyService->getResponse(m::mock(Configuration::class),m::mock(Request::class));
        $this->assertInstanceOf(SuccessResponse::class, $response);
    }

}