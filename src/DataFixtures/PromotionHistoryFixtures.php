<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;
use App\Entity\PromotionHistory;

class PromotionHistoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $cartRepository = $manager->getRepository("App\Entity\Cart");
        $promotionRepository = $manager->getRepository("App\Entity\Promotion");

        $cart = $cartRepository->findOneByReference("LHPG523");
        $promotion = $promotionRepository->findOneByCode("MERRY-CHRISTMAS");
        $promotion2 = $promotionRepository->findOneByCode("WELCOME");
        $promotion3 = $promotionRepository->findOneByCode("CODE-5");
        $promotion4 = $promotionRepository->findOneByCode("CODE-20");

        $promotionHistories = [
            [
                "promotion" => $promotion,
                "user" => $cart->getUser(),
                "cart" => $cart,
                "created_at" => new DateTimeImmutable("2022-12-24 23:59:59")
            ],
            [
                "promotion" => $promotion2,
                "user" => $cart->getUser(),
                "cart" => $cart,
                "created_at" => new DateTimeImmutable("2022-12-24 23:59:59")
            ],
            [
                "promotion" => $promotion3,
                "user" => $cart->getUser(),
                "cart" => $cart,
                "created_at" => new DateTimeImmutable("2022-12-24 23:59:59")
            ],
            [
                "promotion" => $promotion4,
                "user" => $cart->getUser(),
                "cart" => $cart,
                "created_at" => new DateTimeImmutable("2022-12-24 23:59:59")
            ]
        ];

        foreach ($promotionHistories as $promotionHistoryInfos) {
            $promotionHistory = new PromotionHistory();
            $promotionHistory->setPromotion($promotionHistoryInfos["promotion"]);
            $promotionHistory->setUser($promotionHistoryInfos["user"]);
            $promotionHistory->setCart($promotionHistoryInfos["cart"]);
            $promotionHistory->setCreatedAt($promotionHistoryInfos["created_at"]);

            $manager->persist($promotionHistory);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\CartFixtures", "App\DataFixtures\PromotionFixtures", "App\DataFixtures\UserFixtures");
    }
}
