<?php

namespace App\Tests\Unit\Service;

use App\Entity\Product;
use App\Entity\Brand;
use App\Service\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    private $productService;

    protected function setUp(): void
    {
        $this->productService = new ProductService();
    }

    public function testGetVatWithBrandVatNotNull()
    {
        $brand = new Brand();
        $brand->setVat(10);

        $product = New Product();
        $product->setBrand($brand);

        $this->assertSame(10.0, $this->productService->getVat($product));
    }

    public function testGetVatWithBrandVatNull()
    {
        $brand = new Brand();

        $product = New Product();
        $product->setBrand($brand);

        $this->assertSame(20.0, $this->productService->getVat($product));
    }
}