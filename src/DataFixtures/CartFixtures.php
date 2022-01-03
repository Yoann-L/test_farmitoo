<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Cart;
use DateTimeImmutable;

class CartFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $userRepository = $manager->getRepository("App\Entity\User");
        $countryRepository = $manager->getRepository("App\Entity\Country");

        $user = $userRepository->findOneByEmail("admin@gmail.com");
        $country = $countryRepository->findOneBy(["ISO" => "FR"]);

        $carts = [
            [
                "country" => null,
                "status" => Cart::CART_CREATED,
                "user" => null,
                "created_at" => new DateTimeImmutable("NOW"),
                "reference" => "ERF25ER",
            ],
            [
                "country" => $country,
                "status" => Cart::CART_CREATED,
                "user" => $user,
                "created_at" => new DateTimeImmutable("NOW"),
                "reference" => "LHPG523",
            ]
        ];

        foreach ($carts as $cartInfos) {
            $cart = new Cart();
            $cart->setCountry($cartInfos["country"]);
            $cart->setStatus($cartInfos["status"]);
            $cart->setUser($cartInfos["user"]);
            $cart->setCreatedAt($cartInfos["created_at"]);
            $cart->setReference($cartInfos["reference"]);

            $manager->persist($cart);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\UserFixtures", "App\DataFixtures\CountryFixtures");
    }
}
