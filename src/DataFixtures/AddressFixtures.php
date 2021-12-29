<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Address;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $countryRepository = $manager->getRepository("App\Entity\Country");
        $userRepository = $manager->getRepository("App\Entity\User");

        $france = $countryRepository->findOneBy(["ISO" => "FR"]);
        $germany = $countryRepository->findOneBy(["ISO" => "DE"]);

        $user = $userRepository->findOneByEmail("admin@gmail.com");

        $addresses = [
            [
                "country" => $france,
                "user" => $user,
                "city" => "Paris",
                "state" => "Ile de france",
                "postal_code" => "75001"
            ],
            [
                "country" => $germany,
                "user" => $user,
                "city" => "Berlin",
                "state" => "Berlin",
                "postal_code" => "10115"
            ]
        ];

        foreach ($addresses as $addressInfos) {
            $address = new Address();
            $address->setCountry($addressInfos["country"]);
            $address->setUser($addressInfos["user"]);
            $address->setCity($addressInfos["city"]);
            $address->setState($addressInfos["state"]);
            $address->setPostalCode($addressInfos["postal_code"]);

            $manager->persist($address);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\CountryFixtures", "App\DataFixtures\UserFixtures");
    }
}
