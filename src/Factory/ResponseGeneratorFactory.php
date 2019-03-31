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
        switch ($responseType) {
            case 'Products':
                return new ProductResponseGenerator(new ProductHydrator());
            case 'Attributes':
                return new CategoryResponseGenerator(new CategoryAttributeHydrator());
            case 'FeedDetail':
                return new FeedStatusResponseGenerator(new FeedStatusHydrator());
            case $responseType == 'Order' || $responseType == 'Orders':
                return new OrderResponseGenerator(new OrderHydrator());
            case 'OrderItems':
                return new OrderItemResponseGenerator(new OrderItemHydrator());
            default:
                throw new \InvalidArgumentException("$responseType is invalid");
        }
    }
}