<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Country;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $countries = [
            [
                "iso" => "FR",
                "iso3" => "FRA",
                "name" => "France",
                "tva" => 20
            ],
            [
                "iso" => "BE",
                "iso3" => "BEL",
                "name" => "Belgium",
                "tva" => 21
            ],
            [
                "iso" => "DE",
                "iso3" => "DEU",
                "name" => "Germany",
                "tva" => 16
            ],
            [
                "iso" => "PL",
                "iso3" => "POL",
                "name" => "Poland",
                "tva" => 23
            ]
        ];

        foreach ($countries as $countryInfos) {
            $country = new Country();
            $country->setISO($countryInfos["iso"]);
            $country->setISO3($countryInfos["iso3"]);
            $country->setName($countryInfos["name"]);
            $country->setTVA($countryInfos["tva"]);

            $manager->persist($country);
        }

        $manager->flush();
    }
}
