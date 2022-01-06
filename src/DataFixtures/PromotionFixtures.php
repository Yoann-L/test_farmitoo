<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Promotion;
use DateTimeImmutable;

class PromotionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $date = new DateTimeImmutable("2022-12-24 23:59:59");
        $date2 = new DateTimeImmutable("2021-12-24 23:59:59");

        $promotions = [
            [
                "code" => "WELCOME",
                "status" => Promotion::PROMOTION_ENABLE,
                "expirated_at" => $date,
                "usage_limit_by_user" => 1,
                "nb_product_stock" => null,
                "min_price_cart" => 50,
                "min_nb_product_cart" => null,
                "user" => null,
                "discount_percentage" => null,
                "discount_fix" => 10,
                "free_shipping_fees" => false,
                "type" => Promotion::PROMOTION_TYPE_CART
            ],
            [
                "code" => "MERRY-CHRISTMAS",
                "status" => Promotion::PROMOTION_ENABLE,
                "expirated_at" => $date,
                "usage_limit_by_user" => 1,
                "nb_product_stock" => null,
                "min_price_cart" => 200,
                "min_nb_product_cart" => null,
                "user" => null,
                "discount_percentage" => null,
                "discount_fix" => null,
                "free_shipping_fees" => true,
                "type" => Promotion::PROMOTION_TYPE_CART
            ],
            [
                "code" => "CODE-5",
                "status" => Promotion::PROMOTION_ENABLE,
                "expirated_at" => $date,
                "usage_limit_by_user" => 1,
                "nb_product_stock" => null,
                "min_price_cart" => 200,
                "min_nb_product_cart" => null,
                "user" => null,
                "discount_percentage" => 5,
                "discount_fix" => null,
                "free_shipping_fees" => false,
                "type" => Promotion::PROMOTION_TYPE_CART
            ],
            [
                "code" => "CODE-20",
                "status" => Promotion::PROMOTION_ENABLE,
                "expirated_at" => $date2,
                "usage_limit_by_user" => 1,
                "nb_product_stock" => null,
                "min_price_cart" => 200,
                "min_nb_product_cart" => null,
                "user" => null,
                "discount_percentage" => 20,
                "discount_fix" => null,
                "free_shipping_fees" => false,
                "type" => Promotion::PROMOTION_TYPE_CART
            ]
            
        ];

        foreach ($promotions as $promotionInfos) {
            $promotion = new Promotion();
            $promotion->setCode($promotionInfos["code"]);
            $promotion->setStatus($promotionInfos["status"]);
            $promotion->setExpiratedAt($promotionInfos["expirated_at"]);
            $promotion->setUsageLimitByUser($promotionInfos["usage_limit_by_user"]);
            $promotion->setNbProductStock($promotionInfos["nb_product_stock"]);
            $promotion->setMinPriceCart($promotionInfos["min_price_cart"]);
            $promotion->setMinNbProductCart($promotionInfos["min_nb_product_cart"]);
            $promotion->setUser($promotionInfos["user"]);
            $promotion->setDiscountPercentage($promotionInfos["discount_percentage"]);
            $promotion->setDiscountFix($promotionInfos["discount_fix"]);
            $promotion->setFreeShippingFees($promotionInfos["free_shipping_fees"]);
            $promotion->setType($promotionInfos["type"]);

            $manager->persist($promotion);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\UserFixtures");
    }
}
