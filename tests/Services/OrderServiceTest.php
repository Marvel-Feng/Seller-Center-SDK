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
use SellerCenter\Model\Configuration;
use SellerCenter\Model\Order;
use SellerCenter\Model\OrderItem;
use SellerCenter\Model\Request;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Services\OrderService;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderServiceTest extends TestCase
{
    /**
     * @param array $data
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @dataProvider getOrderItemsTestCases
     */
    public function testGetOrderItems(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')
            ->andReturn([new OrderItem()])
            ->getMock();
        $sellerCenterRequest = new Request();
        $parameters          = [
            Request::QUERY_PARAMETER_ACTION   => $data[Request::QUERY_PARAMETER_ACTION],
            Request::QUERY_PARAMETER_ORDER_ID => $data[Request::QUERY_PARAMETER_ORDER_ID],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response        = $orderService->getOrderItems(
            $config,
            $data[Request::QUERY_PARAMETER_ORDER_ID]
        );
        $this->assertInstanceOf(OrderItem::class, current($response));
    }

    /**
     * @param array $data
     *
     * @throws SellerCenterException
     * @throws GuzzleException
     * @dataProvider getOrdersTestCases
     */
    public function testGetOrders(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')
            ->andReturn([new Order()])
            ->getMock();
        $sellerCenterRequest = new Request();
        $parameters          = [
            Request::QUERY_PARAMETER_ACTION   => $data[Request::QUERY_PARAMETER_ACTION]
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response        = $orderService->getOrders(
            $config,
            []
        );
        $this->assertInstanceOf(Order::class, current($response));
    }

    /**
     * @param array $data
     *
     * @throws SellerCenterException
     * @throws GuzzleException
     * @dataProvider cancelOrderTestCases
     */
    public function testCancelOrder(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class);
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION        => $data[Request::QUERY_PARAMETER_ACTION],
            Request::QUERY_PARAMETER_ORDER_ITEM_ID => $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response        = $orderService->cancelOrder(
            $config,
            $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID]
        );
        $this->assertInstanceOf(SuccessResponse::class, $response);
    }

    /**
     * @param array $data
     *
     * @throws SellerCenterException
     * @throws GuzzleException
     * @dataProvider getOrderTestCases
     */
    public function testGetOrder(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')
            ->andReturn([new Order()])
            ->getMock();
        $sellerCenterRequest = new Request();
        $parameters          = [
            Request::QUERY_PARAMETER_ACTION   => $data[Request::QUERY_PARAMETER_ACTION],
            Request::QUERY_PARAMETER_ORDER_ID => $data[Request::QUERY_PARAMETER_ORDER_ID],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response        = $orderService->getOrder(
            $config,
            $data[Request::QUERY_PARAMETER_ORDER_ID]
        );
        $this->assertInstanceOf(Order::class, $response);
    }

    /**
     * @return array
     */
    public function cancelOrderTestCases()
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
                    Request::QUERY_PARAMETER_ACTION        => Request::ACTION_SET_CANCELLED_STATUS,
                    Request::QUERY_PARAMETER_ORDER_ITEM_ID => '111',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getOrderTestCases()
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
                    Request::QUERY_PARAMETER_ACTION   => Request::ACTION_GET_ORDER,
                    Request::QUERY_PARAMETER_ORDER_ID => '111',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getOrderItemsTestCases()
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
                    Request::QUERY_PARAMETER_ACTION   => Request::ACTION_GET_ORDER_ITEMS,
                    Request::QUERY_PARAMETER_ORDER_ID => '111',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getOrdersTestCases()
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
                    Request::QUERY_PARAMETER_ACTION   => Request::ACTION_GET_ORDERS
                ],
            ],
        ];
    }

}