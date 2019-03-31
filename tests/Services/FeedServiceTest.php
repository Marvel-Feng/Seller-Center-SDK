<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 17/01/19
 * Time: 02:58 م
 */

namespace SellerCenter\tests\Services;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use SellerCenter\Proxy\SellerCenterProxy as Proxy;
use Mockery as m;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\FeedStatus;
use SellerCenter\Model\Request;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Services\FeedService;

class FeedServiceTest extends TestCase
{
    /**
     * @param array $data
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @throws \ReflectionException
     * @dataProvider getFeedStatusTestCases
     */
    public function testGetFeedStatus(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')->andReturn(new FeedStatus())->getMock();
        $sellerCenterRequest = new Request();
        $parameters = [
            Request::QUERY_PARAMETER_FEED_ID => $data[Request::QUERY_PARAMETER_FEED_ID],
            Request::QUERY_PARAMETER_ACTION  => $data[Request::QUERY_PARAMETER_ACTION]
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse',[$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $feedService = new FeedService();
        $reflection = new \ReflectionClass($feedService);
        $property = $reflection->getProperty('sellerCenterProxy');
        $property->setAccessible(true);
        $property->setValue($feedService,$sellerCenterProxyMock);
        $response = $feedService->getFeedStatus(
            $config,
           $data[Request::QUERY_PARAMETER_FEED_ID]
        );
        $this->assertInstanceOf(FeedStatus::class,$response);
    }

    /**
     * @return array
     */
    public function getFeedStatusTestCases()
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
                    'configuration'                           => $configuration,
                    Request::QUERY_PARAMETER_FEED_ID => '1',
                    Request::QUERY_PARAMETER_ACTION  => Request::ACTION_GET_FEED_STATUS
                ]
            ]
        ];
    }

}