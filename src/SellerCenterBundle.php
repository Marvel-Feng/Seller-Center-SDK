<?php

namespace SellerCenter;

use SellerCenter\DependencyInjection\SellerCenterExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SellerCenterBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SellerCenterExtension();
    }
}