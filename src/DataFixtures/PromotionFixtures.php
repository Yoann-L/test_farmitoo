<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Promotion;
use DateTimeImmutable;

class PromotionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date = new DateTimeImmutable("2021-12-24 23:59:59");

        $promotions = [
            [
                "code" => "WELCOME",
                "expirated_at" => null,
                "quantity_available" => 1,
                "discount_percentage" => null,
                "discount_value" => 10,
                "min_amount" => 15,
                "status" => Promotion::PROMOTION_ENABLE,
            ],
            [
                "code" => "MERRY-CHRISTMAS",
                "expirated_at" => $date,
                "quantity_available" => 10,
                "discount_percentage" => 10,
                "discount_value" => null,
                "min_amount" => 45,
                "status" => Promotion::PROMOTION_ENABLE,
            ]
            
        ];

        foreach ($promotions as $promotionInfos) {
            $promotion = new Promotion();
            $promotion->setCode($promotionInfos["code"]);
            $promotion->setExpiratedAt($promotionInfos["expirated_at"]);
            $promotion->setQuantityAvailable($promotionInfos["quantity_available"]);
            $promotion->setDiscountPercentage($promotionInfos["discount_percentage"]);
            $promotion->setDiscountValue($promotionInfos["discount_value"]);
            $promotion->setMinAmount($promotionInfos["min_amount"]);
            $promotion->setStatus($promotionInfos["status"]);

            $manager->persist($promotion);
        }

        $manager->flush();
    }
}
