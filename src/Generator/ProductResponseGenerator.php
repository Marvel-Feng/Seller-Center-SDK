<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 13/01/19
 * Time: 05:15 م
 */

namespace SellerCenter\Generator;

use SellerCenter\Model\Product;

class ProductResponseGenerator extends ResponseGenerator
{

    /**
     * @param array $body
     *
     * @return Product[]
     * @throws \Exception
     */
    public function makeBody(array $body): array
    {
        $products     = [];
        $productsBody = array_get($body, Product::SC_PRODUCTS.'.'.Product::SC_PRODUCT, []);
        if (!empty($productsBody)) {
            $productsBody = $this->to2DArrayIfNot($productsBody);
            foreach ($productsBody as $product) {
                $newProduct = new Product();
                $this->hydrator->hydrate($product, $newProduct);
                $products[] = $newProduct;
            }
        }

        return $products;
    }
}