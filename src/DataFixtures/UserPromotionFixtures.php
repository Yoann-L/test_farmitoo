<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserPromotionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $userRepository = $manager->getRepository("App\Entity\User");
        $promotionRepository = $manager->getRepository("App\Entity\Promotion");

        $user = $userRepository->findOneByemail("admin@gmail.com");
        $promotion = $promotionRepository->findOneByCode("WELCOME");

        $user->addPromotion($promotion);

        $manager->persist($user);
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\UserFixtures", "App\DataFixtures\PromotionFixtures");
    }
}
