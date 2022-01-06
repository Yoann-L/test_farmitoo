<?php

namespace App\Tests\Unit\Service;

use App\Entity\Product;
use App\Entity\Item;
use App\Entity\Brand;
use App\Service\ItemService;
use App\Service\ProductService;
use PHPUnit\Framework\TestCase;

class ItemServiceTest extends TestCase
{
    private $itemService;

    private $productService;

    protected function setUp(): void
    {
        $this->productService = new ProductService();
        $this->itemService = new ItemService($this->productService);
    }

    public function testCalculVatAmount()
    {
        $brand = New Brand();
        $brand->setVat(10);

        $product = New Product();
        $product->setPrice(200);
        $product->setBrand($brand);

        $item = New Item();
        $item->setProduct($product);
        $item->setQuantity(2);

        $this->assertSame(40.0, $this->itemService->calculVatAmount($item));
    }
}