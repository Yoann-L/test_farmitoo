<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\BrandCountryVat;

class BrandCountryVatFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $countryRepository = $manager->getRepository("App\Entity\Country");
        $brandRepository = $manager->getRepository("App\Entity\Brand");

        $france = $countryRepository->findOneBy(["ISO" => "FR"]);
        $germany = $countryRepository->findOneBy(["ISO" => "DE"]);

        $brand = $brandRepository->findOneByslug("farmitoo");

        $brandCountryVatList = [
            [
                "brand" => $brand,
                "country" => $france,
                "vat" => 22
            ],
            [
                "brand" => $brand,
                "country" => $germany,
                "vat" => 20
            ]
        ];

        foreach ($brandCountryVatList as $brandCountryVatInfos) {
            $brandCountryVat = new BrandCountryVat();
            $brandCountryVat->setBrand($brandCountryVatInfos["brand"]);
            $brandCountryVat->setCountry($brandCountryVatInfos["country"]);
            $brandCountryVat->setVat($brandCountryVatInfos["vat"]);

            $manager->persist($brandCountryVat);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\BrandFixtures", "App\DataFixtures\UserFixtures");
    }
}
