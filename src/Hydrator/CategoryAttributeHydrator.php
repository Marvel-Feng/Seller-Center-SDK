<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 20/01/19
 * Time: 04:37 م
 */

namespace SellerCenter\Hydrator;

use SellerCenter\Model\CategoryAttribute;

class CategoryAttributeHydrator implements Hydrator
{

    /**
     * @param array             $data
     * @param CategoryAttribute $newCategory
     */
    public function hydrate(array $data, &$newCategory)
    {
        $options = array_get(
            $data,
            CategoryAttribute::SC_CATEGORY_MULTIPLE_OPTIONS.'.'
            .CategoryAttribute::SC_CATEGORY_SINGLE_OPTION,
            []
        );
        $newCategory->setOptions($options);
        $newCategory->setDescription($data[CategoryAttribute::SC_CATEGORY_DESCRIPTION]);
        $newCategory->setName($data[CategoryAttribute::SC_CATEGORY_NAME]);
        $newCategory->setLabel($data[CategoryAttribute::SC_CATEGORY_LABEL]);
        $newCategory->setIsMandatory($data[CategoryAttribute::SC_CATEGORY_IS_MANDATORY]);
        $newCategory->setAttributeType($data[CategoryAttribute::SC_CATEGORY_ATTRIBUTE_TYPE]);
        $newCategory->setExampleValue($data[CategoryAttribute::SC_CATEGORY_EXAMPLE_VALUE]);
        $newCategory->setGlobalIdentifier(
            $data[CategoryAttribute::SC_CATEGORY_GLOBAL_IDENTIFIER]
        );
    }
}