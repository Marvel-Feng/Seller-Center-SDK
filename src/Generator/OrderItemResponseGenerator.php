<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 3/24/19
 * Time: 1:33 PM
 */

namespace SellerCenter\Generator;

use SellerCenter\Model\OrderItem;

class OrderItemResponseGenerator extends ResponseGenerator
{

    /**
     * @param array $body
     *
     * @return OrderItem[]
     */
    protected function makeBody(array $body): array
    {
        $orderItems     = [];
        $orderItemsBody = array_get(
            $body,
            OrderItem::SC_ORDER_ITEM_ORDER_ITEMS.'.'.OrderItem::SC_ORDER_ITEM_ORDER_ITEM,
            []
        );
        if (isset($orderItemsBody)) {
            $orderItemsBody = $this->to2DArrayIfNot($orderItemsBody);
            foreach ($orderItemsBody as $orderItemBody) {
                $orderItem = new OrderItem();
                $this->hydrator->hydrate($orderItemBody, $orderItem);
                $orderItems[] = $orderItem;
            }
        }

        return $orderItems;
    }
}