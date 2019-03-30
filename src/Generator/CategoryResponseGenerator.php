<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 14/01/19
 * Time: 10:55 ص
 */

namespace SellerCenter\Generator;

use SellerCenter\Model\CategoryAttribute;

class CategoryResponseGenerator extends ResponseGenerator
{

    /**
     * @param array $body
     *
     * @return CategoryAttribute[]
     */
    public function makeBody(array $body): array
    {
        $attributes     = [];
        $attributesBody = array_get($body, CategoryAttribute::SC_CATEGORY_ATTRIBUTE, []);
        if (!empty($attributesBody)) {
            $attributesBody = $this->to2DArrayIfNot($attributesBody);
            foreach ($attributesBody as $attribute) {
                $newAttribute = new CategoryAttribute();
                $this->hydrator->hydrate($attribute, $newAttribute);
                $attributes[] = $newAttribute;
            }
        }

        return $attributes;
    }
}