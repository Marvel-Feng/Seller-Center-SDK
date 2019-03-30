<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 3/24/19
 * Time: 1:32 PM
 */

namespace SellerCenter\Hydrator;

use SellerCenter\Generator\ResponseGenerator;
use SellerCenter\Model\AddressShipping;
use SellerCenter\Model\Order;
use SellerCenter\Model\OrderItem;

class OrderHydrator implements Hydrator
{

    /**
     * @param array $data
     * @param Order $order
     *
     * @throws \Exception
     */
    public function hydrate(array $data, &$order)
    {
        $extractor = function ($key) use ($data) {
            return array_get($data, $key);
        };
        $order->setOrderId($extractor(Order::SC_ORDER_ID));
        $order->setOrderNumber($extractor(Order::SC_ORDER_NUMBER));
        $orderItemsBody = $extractor(Order::SC_ORDER_ITEMS.'.'.Order::SC_ORDER_ITEM);
        if (isset($orderItemsBody)) { // This means this is a request from GetMultipleOrderItems
            $orderItems         = [];
            $orderItemsBody     = ResponseGenerator::to2DArrayIfNot($orderItemsBody);
            $orderItemsHydrator = new OrderItemHydrator();
            foreach ($orderItemsBody as $orderItemBody) {
                $orderItem = new OrderItem();
                $orderItemsHydrator->hydrate($orderItemBody, $orderItem);
                $orderItems[] = $orderItem;
            }
            $order->setItems($orderItems);
        } else { // In case of GetMultipleOrderItems we don't have these fields
            $order->setCustomerFirstName($extractor(Order::SC_ORDER_CUSTOMER_FIRST_NAME));
            $order->setCustomerLastName($extractor(Order::SC_ORDER_CUSTOMER_LAST_NAME));
            $order->setPaymentMethod($extractor(Order::SC_ORDER_PAYMENT_METHOD));
            $order->setDeliveryInfo($extractor(Order::SC_ORDER_DELIVERY_INFO));
            $order->setPrice($extractor(Order::SC_ORDER_PRICE));
            $order->setCreatedAt(new \DateTime($extractor(Order::SC_ORDER_CREATED_AT)));
            $order->setUpdatedAt(new \DateTime($extractor(Order::SC_ORDER_UPDATED_AT)));
            $addressShipping     = new AddressShipping();
            $addressShippingBody = $extractor(Order::SC_ORDER_ADDRESS_SHIPPING);
            if (isset($addressShippingBody)) {
                $addressShipping->setFirstName(
                    array_get($addressShippingBody, AddressShipping::SC_SHIPPING_FIRST_NAME)
                );
                $addressShipping->setLastName(array_get($addressShippingBody, AddressShipping::SC_SHIPPING_LAST_NAME));
                $addressShipping->setPhone(array_get($addressShippingBody, AddressShipping::SC_SHIPPING_PHONE));
                $addressShipping->setAddress1(array_get($addressShippingBody, AddressShipping::SC_SHIPPING_ADDRESS_1));
                $addressShipping->setCustomerEmail(
                    array_get($addressShippingBody, AddressShipping::SC_SHIPPING_CUSTOMER_EMAIL)
                );
                $addressShipping->setCity(array_get($addressShippingBody, AddressShipping::SC_SHIPPING_CITY));
                $addressShipping->setCountry(array_get($addressShippingBody, AddressShipping::SC_SHIPPING_COUNTRY));
            }
            $order->setShippingAddress($addressShipping);
            $order->setStatus($extractor(Order::SC_ORDER_STATUSES.'.'.Order::SC_ORDER_STATUS));
        }

    }
}