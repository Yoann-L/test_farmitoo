<?php

namespace App\Service;

use App\Entity\Product;

class ProductService
{
    /**
     * Get VAT for a product, for this test return the brand's VAT but we can use others specific rules (Country...)
     * 
     * @param Product $product
     * 
     * @return float 
     **/
    public function getVat(Product $product): float 
    {
        return $product->getBrand()->getVat() !== null ? $product->getBrand()->getVat() : 20.0;
    }
}