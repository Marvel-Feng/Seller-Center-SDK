<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 20/01/19
 * Time: 04:34 م
 */

namespace SellerCenter\Hydrator;

interface Hydrator
{
    /**
     * @param array $data
     * @param       $object
     */
    public function hydrate(array $data,&$object);
}