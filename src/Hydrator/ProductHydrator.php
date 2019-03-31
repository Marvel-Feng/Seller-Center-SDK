<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 20/01/19
 * Time: 04:37 م
 */

namespace SellerCenter\Hydrator;

use Illuminate\Support\Arr;
use SellerCenter\Model\Product;

class ProductHydrator implements Hydrator
{

    /**
     * @param array   $product
     * @param Product $newProduct
     *
     * @throws \Exception
     */
    public function hydrate(array $product, &$newProduct)
    {
        $newProduct->setSellerSku($product[Product::SC_PRODUCT_SELLER_SKU]);
        $newProduct->setShopSku($product[Product::SC_PRODUCT_SHOP_SKU]);
        $newProduct->setName($product[Product::SC_PRODUCT_NAME]);
        $newProduct->setBrand($product[Product::SC_PRODUCT_BRAND]);
        $newProduct->setDescription($product[Product::SC_PRODUCT_DESCRIPTION]);
        $newProduct->setTaxClass($product[Product::SC_PRODUCT_TAX_CLASS]);
        $newProduct->setVariation($product[Product::SC_PRODUCT_VARIATION]);
        $newProduct->setParentSku($product[Product::SC_PRODUCT_PARENT_SKU]);
        $newProduct->setQuantity($product[Product::SC_PRODUCT_QUANTITY]);
        $newProduct->setFulfillmentByNonSellable(
            Arr::get($product,Product::SC_PRODUCT_FULLFILLMENT)
        );
        $newProduct->setAvailable($product[Product::SC_PRODUCT_AVAILABLE]);
        $newProduct->setPrice($product[Product::SC_PRODUCT_PRICE]);
        if (isset($product[Product::SC_PRODUCT_SALE_PRICE], $product[Product::SC_PRODUCT_SALE_END_DATE], $product[Product::SC_PRODUCT_SALE_START_DATE])) {
            $newProduct->setSalePrice($product[Product::SC_PRODUCT_SALE_PRICE]);
            $newProduct->setSaleStartDate(
                new \DateTime($product[Product::SC_PRODUCT_SALE_START_DATE])
            );
            $newProduct->setSaleEndDate(
                new \DateTime($product[Product::SC_PRODUCT_SALE_END_DATE])
            );
        }
        $newProduct->setStatus($product[Product::SC_PRODUCT_STATUS]);
        $newProduct->setProductId($product[Product::SC_PRODUCT_ID]);
        $newProduct->setUrl($product[Product::SC_PRODUCT_URL]);
        $newProduct->setMainImage($product[Product::SC_PRODUCT_MAIN_IMAGE]);
        if (!empty($product[Product::SC_PRODUCT_MULTIPLE_IMAGES])) {
            $images = array_values(
                Arr::get(
                    $product,
                    Product::SC_PRODUCT_MULTIPLE_IMAGES,
                    []
                )
            );
            $newProduct->setImages($images);
        }
        $newProduct->setPrimaryCategory($product[Product::SC_PRODUCT_PRIMARY_CATEGORY]);
            $newProduct->setCategories(
                Arr::get($product,Product::SC_PRODUCT_CATEGORIES)
            );
        $productData = $product[Product::SC_PRODUCT_DATA];
        $newProduct->setMainMaterial(
            Arr::get($productData,Product::SC_PRODUCT_MAIN_MATERIAL)
        );
        $newProduct->setProductWeight(
            Arr::get($productData,Product::SC_PRODUCT_WEIGHT)
        );
        $newProduct->setDescriptionArEG(
            Arr::get($productData,Product::SC_PRODUCT_DESCRIPTION_AR_EG)
        );
        $newProduct->setNameArEG(
          Arr::get($productData,Product::SC_PRODUCT_NAME_AR_EG)
        );
        $newProduct->setColor(
            Arr::get($productData,Product::SC_PRODUCT_COLOR)
        );
    }
}