<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Cart;

class CartPromotionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $cartRepository = $manager->getRepository("App\Entity\Cart");
        $promotionRepository = $manager->getRepository("App\Entity\Promotion");

        $cart = $cartRepository->findOneByReference("ERF25ER");
        $promotion = $promotionRepository->findOneByCode("WELCOME");

        $cart->addPromotion($promotion);

        $manager->persist($cart);
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\CartFixtures", "App\DataFixtures\PromotionFixtures");
    }
}
