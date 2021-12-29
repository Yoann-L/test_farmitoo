<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Order;

class OrderPromotionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $orderRepository = $manager->getRepository("App\Entity\Order");
        $promotionRepository = $manager->getRepository("App\Entity\Promotion");

        $order = $orderRepository->findOneByReference("ERF25ER");
        $promotion = $promotionRepository->findOneByCode("WELCOME");

        $order->addPromotion($promotion);

        $manager->persist($order);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\OrderFixtures", "App\DataFixtures\PromotionFixtures");
    }
}
