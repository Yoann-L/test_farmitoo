<?php

namespace App\Tests\Unit\Service;

use App\Entity\Brand;
use App\Service\BrandService;
use PHPUnit\Framework\TestCase;
use Exception;

class BrandServiceTest extends TestCase
{
    private $brandService;

    protected function setUp(): void
    {
        $this->brandService = new BrandService();
    }

    public function testGetShippingFeesForFarmitooLessThreeItems()
    {
        $brand = New Brand();
        $brand->setSlug("farmitoo");

        $this->assertSame(20.0, $this->brandService->getShippingFees($brand, 2));
    }

    public function testGetShippingFeesForFarmitooExactThreeItems()
    {
        $brand = New Brand();
        $brand->setSlug("farmitoo");

        $this->assertSame(20.0, $this->brandService->getShippingFees($brand, 3));
    }

    public function testGetShippingFeesForFarmitooMoreThreeItems()
    {
        $brand = New Brand();
        $brand->setSlug("farmitoo");

        $this->assertSame(40.0, $this->brandService->getShippingFees($brand, 4));
    }

    public function testGetShippingFeesForFarmitooWithoutItems()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("At least one item is needed to calculate Farmitoo shipping fees");

        $brand = New Brand();
        $brand->setSlug("farmitoo");

        $this->brandService->getShippingFees($brand);
    }

    public function testGetShippingFeesForGallagher()
    {
        $brand = New Brand();
        $brand->setSlug("gallagher");

        $this->assertSame(15.0, $this->brandService->getShippingFees($brand));
    }

    public function testGetShippingFeesDefault()
    {
        $brand = New Brand();
        $brand->setSlug("brand-not-exist");

        $this->assertSame(5.0, $this->brandService->getShippingFees($brand));
    }
}