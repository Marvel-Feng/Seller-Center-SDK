<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 3/24/19
 * Time: 1:33 PM
 */

namespace SellerCenter\Hydrator;

use SellerCenter\Model\OrderItem;

class OrderItemHydrator implements Hydrator
{

    /**
     * @param array     $data
     * @param OrderItem $orderItem
     *
     * @throws \Exception
     */
    public function hydrate(array $data, &$orderItem)
    {
        $extractor = function ($key) use ($data) {
            return array_get($data, $key);
        };
        $orderItem->setOrderItemId($extractor(OrderItem::SC_ORDER_ITEM_ID));
        $orderItem->setOrderId($extractor(OrderItem::SC_ORDER_ITEM_ORDER_ID));
        $orderItem->setName($extractor(OrderItem::SC_ORDER_ITEM_NAME));
        $orderItem->setSku($extractor(OrderItem::SC_ORDER_ITEM_SKU));
        $orderItem->setShippingType($extractor(OrderItem::SC_ORDER_ITEM_SHIPPING_TYPE));
        $orderItem->setItemPrice($extractor(OrderItem::SC_ORDER_ITEM_PRICE));
        $orderItem->setStatus($extractor(OrderItem::SC_ORDER_ITEM_STATUS));
        $orderItem->setTrackingCode($extractor(OrderItem::SC_ORDER_ITEM_TRACKING_CODE));
        $orderItem->setUpdatedAt(new \DateTime($extractor(OrderItem::SC_ORDER_ITEM_UPDATED_AT)));
        $orderItem->setCreatedAt(new \DateTime($extractor(OrderItem::SC_ORDER_ITEM_CREATED_AT)));
    }
}