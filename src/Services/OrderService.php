<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 3/21/19
 * Time: 3:24 PM
 */

namespace SellerCenter\Services;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use SellerCenter\Exception\SellerCenterException;
use SellerCenter\Model\Configuration;
use SellerCenter\Model\Request;
use SellerCenter\Model\Order;
use SellerCenter\Model\OrderItem;
use SellerCenter\Model\SuccessResponse;
use SellerCenter\Proxy\SellerCenterProxy;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderService
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
     * @param Configuration $configuration
     * @param string        $orderItemId
     *
     * @return SuccessResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function cancelOrder(Configuration $configuration, string $orderItemId): SuccessResponse
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->addConfiguration($configuration);
        $sellerCenterRequest->setAction(Request::ACTION_SET_CANCELLED_STATUS);
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION        => Request::ACTION_SET_CANCELLED_STATUS,
                Request::QUERY_PARAMETER_ORDER_ITEM_ID => $orderItemId,
            ]
        );

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest);
    }

    /**
     * @param Configuration $configuration
     * @param array         $ordersIds
     *
     * @return Order[]
     * @throws Exception
     * @throws GuzzleException
     */
    public function getMultipleOrderItems(Configuration $configuration, array $ordersIds): array
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->addConfiguration($configuration);
        $sellerCenterRequest->setAction(Request::ACTION_GET_MULTI_ORDER_ITEMS);
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION        => Request::ACTION_GET_MULTI_ORDER_ITEMS,
                Request::QUERY_PARAMETER_ORDER_ID_LIST => $ordersIds,
            ]
        );

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest)
            ->getBody();
    }

    /**
     * @param Configuration $configuration
     * @param array         $data
     *
     * @return Order[]
     * @throws GuzzleException
     * @throws Exception
     */
    public function getMultipleOrdersWithOrderItems(Configuration $configuration, array $data): array
    {
        $orders           = $this->getOrders($configuration, $data);
        $ordersMappedById = [];
        $ordersIds        = [];
        foreach ($orders as $order) {
            $ordersIds[]                            = $order->getOrderId();
            $ordersMappedById[$order->getOrderId()] = $order;
        }
        $multipleOrderItems = $this->getMultipleOrderItems($configuration, $ordersIds);
        $ordersWithItems    = [];
        foreach ($multipleOrderItems as $multipleOrderItem) {
            /**
             * @var Order $mappedOrder
             */
            $mappedOrder = $ordersMappedById[$multipleOrderItem->getOrderId()];
            $mappedOrder->setItems($multipleOrderItem->getItems());
            $ordersWithItems[] = $mappedOrder;
        }

        return $ordersWithItems;
    }

    /**
     * @param Configuration $configuration
     * @param string        $orderId
     *
     * @return Order
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function getOrder(Configuration $configuration, string $orderId): Order
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->addConfiguration($configuration);
        $sellerCenterRequest->setAction(Request::ACTION_GET_ORDER);
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION   => Request::ACTION_GET_ORDER,
                Request::QUERY_PARAMETER_ORDER_ID => $orderId,
            ]
        );

        return current(
            $this->sellerCenterProxy->getResponse($sellerCenterRequest)->getBody()
        );
    }

    /**
     * @param Configuration $configuration
     * @param string        $orderId
     *
     * @return OrderItem[]
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function getOrderItems(Configuration $configuration, string $orderId): array
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->addConfiguration($configuration);
        $sellerCenterRequest->setAction(Request::ACTION_GET_ORDER_ITEMS);
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION   => Request::ACTION_GET_ORDER_ITEMS,
                Request::QUERY_PARAMETER_ORDER_ID => $orderId,
            ]
        );

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest)
            ->getBody();
    }

    /**
     * @param Configuration $configuration
     * @param string        $orderId
     *
     * @return Order
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function getOrderWithOrderItems(Configuration $configuration, string $orderId): Order
    {
        $order = $this->getOrder($configuration, $orderId);
        $order->setItems($this->getOrderItems($configuration, $orderId));

        return $order;
    }

    /**
     * @param Configuration $configuration
     * @param array         $data
     *
     * @return Order[]
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function getOrders(Configuration $configuration, array $data): array
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->addConfiguration($configuration);
        $sellerCenterRequest->setAction(Request::ACTION_GET_ORDERS);
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION         => Request::ACTION_GET_ORDERS,
                Request::QUERY_PARAMETER_CREATED_AFTER  => array_get($data,Request::QUERY_PARAMETER_CREATED_AFTER),
                Request::QUERY_PARAMETER_CREATED_BEFORE => array_get($data,Request::QUERY_PARAMETER_CREATED_BEFORE),
                Request::QUERY_PARAMETER_UPDATED_BEFORE => array_get($data,Request::QUERY_PARAMETER_UPDATED_BEFORE),
                Request::QUERY_PARAMETER_UPDATED_AFTER  => array_get($data,Request::QUERY_PARAMETER_UPDATED_AFTER),
                Request::QUERY_PARAMETER_LIMIT          => array_get($data,Request::QUERY_PARAMETER_LIMIT),
                Request::QUERY_PARAMETER_OFFSET         => array_get($data,Request::QUERY_PARAMETER_OFFSET),
                Request::QUERY_PARAMETER_STATUS         => array_get($data,Request::QUERY_PARAMETER_STATUS),
                Request::QUERY_PARAMETER_SORT_BY        => array_get($data,Request::QUERY_PARAMETER_SORT_BY),
                Request::QUERY_PARAMETER_SORT_DIRECTION => array_get($data,Request::QUERY_PARAMETER_SORT_DIRECTION),
            ]
        );

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest)->getBody();
    }

    /**
     * @param Configuration $configuration
     * @param array         $data
     *
     * @return SuccessResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function setOrderStatusToDelivered(Configuration $configuration, array $data): SuccessResponse
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->addConfiguration($configuration);
        $sellerCenterRequest->setAction(Request::ACTION_SET_TO_DELIVERED_STATUS);
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION         => Request::ACTION_SET_TO_DELIVERED_STATUS,
                Request::QUERY_PARAMETER_ORDER_ITEM_ID  => $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID],
                Request::QUERY_PARAMETER_ORDER_ITEM_IDS => $data[Request::QUERY_PARAMETER_ORDER_ITEM_IDS],
            ]
        );

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest);
    }

    /**
     * @param Configuration $configuration
     * @param array         $data
     *
     * @return SuccessResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function setOrderStatusToFailedDelivery(Configuration $configuration, array $data): SuccessResponse
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->addConfiguration($configuration);
        $sellerCenterRequest->setAction(Request::ACTION_SET_TO_FAILED_DELIVERY_STATUS);
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION         => Request::ACTION_SET_TO_FAILED_DELIVERY_STATUS,
                Request::QUERY_PARAMETER_ORDER_ITEM_ID  => $data[Request::QUERY_PARAMETER_ORDER_ITEM_ID],
                Request::QUERY_PARAMETER_ORDER_ITEM_IDS => $data[Request::QUERY_PARAMETER_ORDER_ITEM_IDS],
            ]
        );

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest);
    }

    /**
     * @param Configuration $configuration
     * @param array         $data
     *
     * @return SuccessResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function setOrderStatusToReadyToShip(Configuration $configuration, array $data): SuccessResponse
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->addConfiguration($configuration);
        $sellerCenterRequest->setAction(Request::ACTION_SET_READY_TO_SHIP_STATUS);
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION            => Request::ACTION_SET_READY_TO_SHIP_STATUS,
                Request::QUERY_PARAMETER_ORDER_ITEM_IDS    => $data[Request::QUERY_PARAMETER_ORDER_ITEM_IDS],
                Request::QUERY_PARAMETER_DELIVERY_TYPE     => $data[Request::QUERY_PARAMETER_DELIVERY_TYPE],
                Request::QUERY_PARAMETER_SHIPPING_PROVIDER => $data[Request::QUERY_PARAMETER_SHIPPING_PROVIDER],
                Request::QUERY_PARAMETER_TRACKING_NUMBER   => $data[Request::QUERY_PARAMETER_TRACKING_NUMBER],
                Request::QUERY_PARAMETER_SERIAL_NUMBER     => $data[Request::QUERY_PARAMETER_SERIAL_NUMBER],
            ]
        );

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest);
    }

    /**
     * @param Configuration $configuration
     * @param string        $orderItemId
     *
     * @return SuccessResponse
     * @throws GuzzleException
     * @throws SellerCenterException
     */
    public function setOrderStatusToShipped(Configuration $configuration, string $orderItemId): SuccessResponse
    {
        $sellerCenterRequest = new Request();
        $sellerCenterRequest->addConfiguration($configuration);
        $sellerCenterRequest->setAction(Request::ACTION_SET_TO_SHIPPED_STATUS);
        $sellerCenterRequest->setParameters(
            [
                Request::QUERY_PARAMETER_ACTION        => Request::ACTION_SET_TO_SHIPPED_STATUS,
                Request::QUERY_PARAMETER_ORDER_ITEM_ID => $orderItemId,
            ]
        );

        return $this->sellerCenterProxy->getResponse($sellerCenterRequest);
    }
}