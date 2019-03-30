<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 13/01/19
 * Time: 05:10 م
 */

namespace SellerCenter\Factory;

use SellerCenter\Generator\CategoryResponseGenerator;
use SellerCenter\Generator\FeedStatusResponseGenerator;
use SellerCenter\Generator\OrderItemResponseGenerator;
use SellerCenter\Generator\OrderResponseGenerator;
use SellerCenter\Generator\ProductResponseGenerator;
use SellerCenter\Generator\ResponseGenerator;
use SellerCenter\Hydrator\CategoryAttributeHydrator;
use SellerCenter\Hydrator\FeedStatusHydrator;
use SellerCenter\Hydrator\OrderHydrator;
use SellerCenter\Hydrator\OrderItemHydrator;
use SellerCenter\Hydrator\ProductHydrator;

class ResponseGeneratorFactory
{

    /**
     * @param string $responseType
     *
     * @return ResponseGenerator
     * @throws \InvalidArgumentException
     */
    public function make(string $responseType): ResponseGenerator
    {
        $hydrator = null;
        switch ($responseType) {
            case 'Products':
                $hydrator = new ProductResponseGenerator(new ProductHydrator());
                break;
            case 'Attributes':
                $hydrator = new CategoryResponseGenerator(new CategoryAttributeHydrator());
                break;
            case 'FeedDetail':
                $hydrator = new FeedStatusResponseGenerator(new FeedStatusHydrator());
                break;
            case $responseType == 'Order' || $responseType == 'Orders':
                $hydrator = new OrderResponseGenerator(new OrderHydrator());
                break;
            case 'OrderItems':
                $hydrator = new OrderItemResponseGenerator(new OrderItemHydrator());
                break;
            default:
                throw new \InvalidArgumentException("$responseType is invalid");
        }

        return $hydrator;
    }
}