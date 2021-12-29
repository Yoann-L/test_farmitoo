<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\BrandCountryTVA;

class BrandCountryTVAFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $countryRepository = $manager->getRepository("App\Entity\Country");
        $brandRepository = $manager->getRepository("App\Entity\Brand");

        $france = $countryRepository->findOneBy(["ISO" => "FR"]);
        $germany = $countryRepository->findOneBy(["ISO" => "DE"]);

        $brand = $brandRepository->findOneByslug("farmitoo");

        $brandCountryTVAList = [
            [
                "brand" => $brand,
                "country" => $france,
                "tva" => 22
            ],
            [
                "brand" => $brand,
                "country" => $germany,
                "tva" => 20
            ]
        ];

        foreach ($brandCountryTVAList as $brandCountryTVAInfos) {
            $brandCountryTVA = new BrandCountryTVA();
            $brandCountryTVA->setBrand($brandCountryTVAInfos["brand"]);
            $brandCountryTVA->setCountry($brandCountryTVAInfos["country"]);
            $brandCountryTVA->setTVA($brandCountryTVAInfos["tva"]);

            $manager->persist($brandCountryTVA);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\BrandFixtures", "App\DataFixtures\UserFixtures");
    }
}
