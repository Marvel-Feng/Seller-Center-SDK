<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 3/24/19
 * Time: 1:32 PM
 */

namespace SellerCenter\Generator;

use Illuminate\Support\Arr;
use SellerCenter\Model\Order;

class OrderResponseGenerator extends ResponseGenerator
{

    /**
     * @param array $body
     *
     * @return Order[]
     */
    protected function makeBody(array $body): array
    {
        $orders     = [];
        $ordersBody = Arr::get($body, Order::SC_ORDERS.".".Order::SC_ORDER, []);
        if (isset($ordersBody)) {
            $ordersBody = $this->to2DArrayIfNot($ordersBody);
            foreach ($ordersBody as $orderBody) {
                $order = new Order();
                $this->hydrator->hydrate($orderBody, $order);
                $orders[] = $order;
            }
        }

        return $orders;
    }
}