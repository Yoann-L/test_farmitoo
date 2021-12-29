<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductPromotionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $productRepository = $manager->getRepository("App\Entity\Product");
        $promotionRepository = $manager->getRepository("App\Entity\Promotion");

        $product = $productRepository->findOneByReference("ABCD1234");
        $promotion = $promotionRepository->findOneByCode("MERRY-CHRISTMAS");

        $product->addPromotion($promotion);

        $manager->persist($product);
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\ProductFixtures", "App\DataFixtures\PromotionFixtures");
    }
}
