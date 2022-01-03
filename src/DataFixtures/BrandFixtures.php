<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Brand;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brands = [
            [
                "name" => "Farmitoo",
                "slug" => "farmitoo",
                "status" => Brand::BRAND_ENABLE,
                "vat" => 20
            ],
            [
                "name" => "Gallagher",
                "slug" => "gallagher",
                "status" => Brand::BRAND_ENABLE,
                "vat" => 5
            ]
        ];

        foreach ($brands as $brandInfos) {
            $brand = new Brand();
            $brand->setName($brandInfos["name"]);
            $brand->setSlug($brandInfos["slug"]);
            $brand->setStatus($brandInfos["status"]);
            $brand->setVat($brandInfos["vat"]);

            $manager->persist($brand);
        }

        $manager->flush();
    }
}
