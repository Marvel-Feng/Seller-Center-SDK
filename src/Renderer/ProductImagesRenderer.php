<?php

namespace SellerCenter\Renderer;

use SellerCenter\Model\Product;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ProductImagesRenderer extends Renderer
{
    /**
     * @param Product[] $products
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(array $products): string
    {
        return $this->twig->render(
            'sc_product_images.xml.twig',
            ['products' => $products]
        );
    }
}