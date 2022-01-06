<?php

namespace App\Tests\Unit\Service;

use App\Entity\Promotion;
use App\Service\PromotionService;
use PHPUnit\Framework\TestCase;
use Exception;
use DateTimeImmutable;

class PromotionServiceTest extends TestCase
{
    private $promotionService;

    protected function setUp(): void
    {
        $this->promotionService = new PromotionService();
    }

    public function testPromotionIsValidWithValidPromotion()
    {
        $promotion = New Promotion();
        $promotion->setStatus(Promotion::PROMOTION_ENABLE);
        $promotion->setExpiratedAt(New DateTimeImmutable("2030-12-24 23:59:59"));

        $this->assertSame(true, $this->promotionService->isActive($promotion));
    }

    public function testPromotionIsValidWithDisablePromotion()
    {
        $promotion = New Promotion();
        $promotion->setStatus(Promotion::PROMOTION_DISABLE);
        $promotion->setExpiratedAt(New DateTimeImmutable("2030-12-24 23:59:59"));

        $this->assertSame(false, $this->promotionService->isActive($promotion));
    }

    public function testPromotionIsValidWithExpiredPromotion()
    {
        $promotion = New Promotion();
        $promotion->setStatus(Promotion::PROMOTION_DISABLE);
        $promotion->setExpiratedAt(New DateTimeImmutable("2021-12-24 23:59:59"));

        $this->assertSame(false, $this->promotionService->isActive($promotion));
    }
}