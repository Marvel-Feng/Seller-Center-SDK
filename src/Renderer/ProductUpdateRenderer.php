<?php

namespace SellerCenter\Renderer;

use SellerCenter\Model\Product;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ProductUpdateRenderer extends Renderer
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
            dirname(dirname(__DIR__)).'/views/sc_product_update.xml.twig',
            ['products' => $products]
        );
    }
}