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
        $response     = $orderService->cancelOrder(
            $config,
            $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID]
        );
        $this->assertInstanceOf(SuccessResponse::class, $response);
    }

    /**
     * @param array $data
     *
     * @throws GuzzleException
     * @dataProvider getMultipleOrderItemsTestCases
     */
    public function testGetMultipleOrderItems(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class)
            ->allows('getBody')
            ->andReturn([new Order()])
            ->getMock();
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION        => $data[Request::QUERY_PARAMETER_ACTION],
            Request::QUERY_PARAMETER_ORDER_ID_LIST => $data[Request::QUERY_PARAMETER_ORDER_ID_LIST],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response     = $orderService->getMultipleOrderItems(
            $config,
            $data[Request::QUERY_PARAMETER_ORDER_ID_LIST]
        );
        $this->assertInstanceOf(Order::class, current($response));
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
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION   => $data[Request::QUERY_PARAMETER_ACTION],
            Request::QUERY_PARAMETER_ORDER_ID => $data[Request::QUERY_PARAMETER_ORDER_ID],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response     = $orderService->getOrder(
            $config,
            $data[Request::QUERY_PARAMETER_ORDER_ID]
        );
        $this->assertInstanceOf(Order::class, $response);
    }

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
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION   => $data[Request::QUERY_PARAMETER_ACTION],
            Request::QUERY_PARAMETER_ORDER_ID => $data[Request::QUERY_PARAMETER_ORDER_ID],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response     = $orderService->getOrderItems(
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
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION => $data[Request::QUERY_PARAMETER_ACTION],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response     = $orderService->getOrders(
            $config,
            []
        );
        $this->assertInstanceOf(Order::class, current($response));
    }

    /**
     * @param array $data
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @dataProvider setOrderStatusToReadyToShipTestCases
     */
    public function testSetOrderStatusReadyToShip(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class);
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION            => Request::ACTION_SET_READY_TO_SHIP_STATUS,
            Request::QUERY_PARAMETER_ORDER_ITEM_IDS    => $data[Request::QUERY_PARAMETER_ORDER_ITEM_IDS],
            Request::QUERY_PARAMETER_DELIVERY_TYPE     => $data[Request::QUERY_PARAMETER_DELIVERY_TYPE],
            Request::QUERY_PARAMETER_SHIPPING_PROVIDER => $data[Request::QUERY_PARAMETER_SHIPPING_PROVIDER],
            Request::QUERY_PARAMETER_TRACKING_NUMBER   => $data[Request::QUERY_PARAMETER_TRACKING_NUMBER],
            Request::QUERY_PARAMETER_SERIAL_NUMBER     => $data[Request::QUERY_PARAMETER_SERIAL_NUMBER],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response     = $orderService->setOrderStatusToReadyToShip(
            $config,
            [
                Request::QUERY_PARAMETER_ORDER_ITEM_IDS    => $data[Request::QUERY_PARAMETER_ORDER_ITEM_IDS],
                Request::QUERY_PARAMETER_DELIVERY_TYPE     => $data[Request::QUERY_PARAMETER_DELIVERY_TYPE],
                Request::QUERY_PARAMETER_SHIPPING_PROVIDER => $data[Request::QUERY_PARAMETER_SHIPPING_PROVIDER],
                Request::QUERY_PARAMETER_TRACKING_NUMBER   => $data[Request::QUERY_PARAMETER_TRACKING_NUMBER],
                Request::QUERY_PARAMETER_SERIAL_NUMBER     => $data[Request::QUERY_PARAMETER_SERIAL_NUMBER],
            ]
        );
        $this->assertInstanceOf(SuccessResponse::class, $response);
    }

    /**
     * @param array $data
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @dataProvider setOrderStatusToDeliveredTestCases
     */
    public function testSetOrderStatusToDelivered(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class);
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION         => Request::ACTION_SET_TO_DELIVERED_STATUS,
            Request::QUERY_PARAMETER_ORDER_ITEM_ID  => $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID],
            Request::QUERY_PARAMETER_ORDER_ITEM_IDS => $data[Request::QUERY_PARAMETER_ORDER_ITEM_IDS],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response     = $orderService->setOrderStatusToDelivered(
            $config,
            [
                Request::QUERY_PARAMETER_ORDER_ITEM_ID  => $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID],
                Request::QUERY_PARAMETER_ORDER_ITEM_IDS => $data[Request::QUERY_PARAMETER_ORDER_ITEM_IDS],
            ]
        );
        $this->assertInstanceOf(SuccessResponse::class, $response);
    }

    /**
     * @param array $data
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @dataProvider setOrderStatusToFailedDeliveryTestCases
     */
    public function testSetOrderStatusToFailedDelivery(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class);
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION         => Request::ACTION_SET_TO_FAILED_DELIVERY_STATUS,
            Request::QUERY_PARAMETER_ORDER_ITEM_ID  => $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID],
            Request::QUERY_PARAMETER_ORDER_ITEM_IDS => $data[Request::QUERY_PARAMETER_ORDER_ITEM_IDS],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response     = $orderService->setOrderStatusToFailedDelivery(
            $config,
            [
                Request::QUERY_PARAMETER_ORDER_ITEM_ID  => $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID],
                Request::QUERY_PARAMETER_ORDER_ITEM_IDS => $data[Request::QUERY_PARAMETER_ORDER_ITEM_IDS],
            ]
        );
        $this->assertInstanceOf(SuccessResponse::class, $response);
    }

    /**
     * @param array $data
     *
     * @throws GuzzleException
     * @throws SellerCenterException
     * @dataProvider setOrderStatusToShippedTestCases
     */
    public function testSetOrderStatusToShipped(array $data)
    {
        $config                      = $data['configuration'];
        $sellerCenterProxyMock       = m::mock(Proxy::class);
        $sellerCenterSuccessResponse = m::mock(SuccessResponse::class);
        $sellerCenterRequest         = new Request();
        $parameters                  = [
            Request::QUERY_PARAMETER_ACTION        => Request::ACTION_SET_TO_SHIPPED_STATUS,
            Request::QUERY_PARAMETER_ORDER_ITEM_ID => $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID],
        ];
        $sellerCenterRequest->setParameters($parameters);
        $sellerCenterRequest->addConfiguration($config);
        $sellerCenterProxyMock->shouldReceive('getResponse', [$sellerCenterRequest])
            ->andReturn($sellerCenterSuccessResponse);
        $orderService = new OrderService($sellerCenterProxyMock, $this->createMock(ValidatorInterface::class));
        $response     = $orderService->setOrderStatusToShipped(
            $config,
            $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID]
        );
        $this->assertInstanceOf(SuccessResponse::class, $response);
    }

    /**
     * @return array
     */
    public function cancelOrderTestCases()
    {
        $validRequest  = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
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
                    'configuration'                        => $configuration,
                    Request::QUERY_PARAMETER_ACTION        => Request::ACTION_SET_CANCELLED_STATUS,
                    Request::QUERY_PARAMETER_ORDER_ITEM_ID => '111',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getMultipleOrderItemsTestCases()
    {
        $validRequest  = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
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
                    'configuration'                        => $configuration,
                    Request::QUERY_PARAMETER_ACTION        => Request::ACTION_GET_MULTI_ORDER_ITEMS,
                    Request::QUERY_PARAMETER_ORDER_ID_LIST => [1, 2, 3],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getOrderItemsTestCases()
    {
        $validRequest  = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
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
                    'configuration'                   => $configuration,
                    Request::QUERY_PARAMETER_ACTION   => Request::ACTION_GET_ORDER_ITEMS,
                    Request::QUERY_PARAMETER_ORDER_ID => '111',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getOrderTestCases()
    {
        $validRequest  = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
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
                    'configuration'                   => $configuration,
                    Request::QUERY_PARAMETER_ACTION   => Request::ACTION_GET_ORDER,
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
        $validRequest  = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
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
                    'configuration'                 => $configuration,
                    Request::QUERY_PARAMETER_ACTION => Request::ACTION_GET_ORDERS,
                ],
            ],
        ];
    }

    public function setOrderStatusToDeliveredTestCases()
    {
        $validRequest  = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
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
                    'configuration'                         => $configuration,
                    Request::QUERY_PARAMETER_ACTION         => Request::ACTION_GET_ORDERS,
                    Request::QUERY_PARAMETER_ORDER_ITEM_ID  => '111',
                    Request::QUERY_PARAMETER_ORDER_ITEM_IDS => [1, 2, 3],
                ],
            ],
        ];
    }

    public function setOrderStatusToFailedDeliveryTestCases()
    {
        $validRequest  = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
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
                    'configuration'                         => $configuration,
                    Request::QUERY_PARAMETER_ACTION         => Request::ACTION_GET_ORDERS,
                    Request::QUERY_PARAMETER_ORDER_ITEM_ID  => '111',
                    Request::QUERY_PARAMETER_ORDER_ITEM_IDS => [1, 2, 3],
                ],
            ],
        ];
    }

    public function setOrderStatusToReadyToShipTestCases()
    {
        $validRequest  = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
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
                    'configuration'                            => $configuration,
                    Request::QUERY_PARAMETER_ACTION            => Request::ACTION_SET_READY_TO_SHIP_STATUS,
                    Request::QUERY_PARAMETER_ORDER_ITEM_IDS    => [1, 2, 3],
                    Request::QUERY_PARAMETER_DELIVERY_TYPE     => 'asdas',
                    Request::QUERY_PARAMETER_SHIPPING_PROVIDER => 'asdas',
                    Request::QUERY_PARAMETER_TRACKING_NUMBER   => '21312',
                    Request::QUERY_PARAMETER_SERIAL_NUMBER     => 'e1c2e12314214e',
                ],
            ],
        ];
    }

    public function setOrderStatusToShippedTestCases()
    {
        $validRequest  = json_decode(file_get_contents(dirname(__DIR__).'/ClientTest/Valid/valid_request.json'), true);
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
                    'configuration'                        => $configuration,
                    Request::QUERY_PARAMETER_ACTION        => Request::ACTION_SET_TO_SHIPPED_STATUS,
                    Request::QUERY_PARAMETER_ORDER_ITEM_ID => '111',
                ],
            ],
        ];
    }

}