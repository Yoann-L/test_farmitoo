<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $brandRepository = $manager->getRepository("App\Entity\Brand");

        $brand1 = $brandRepository->findOneBySlug("farmitoo");
        $brand2 = $brandRepository->findOneBySlug("gallagher");

        $products = [
            [
                "brand" => $brand1,
                "title" => "Caisse à outils 5 compartiments - 400x210x250",
                "price" => 47.75,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "ABCD1234"
            ],
            [
                "brand" => $brand1,
                "title" => "LAME ROTALABOUR G.60X12X250 T16,5 ADAPTABLE HOWARD",
                "price" => 3.41,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "253974EK"
            ],
            [
                "brand" => $brand2,
                "title" => "Lot de 25 - BOULON 6 PANS 16/150X45 10.9 BRUT+GROWER",
                "price" => 28.14,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "542424AZ"
            ],
            [
                "brand" => $brand2,
                "title" => "Dent de faneuse adaptable Krone KW 5.25, KW 4.45",
                "price" => 8.09,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "225648DR"
            ]
        ];

        foreach ($products as $productInfos) {
            $product = new Product();
            $product->setBrand($productInfos["brand"]);
            $product->setTitle($productInfos["title"]);
            $product->setPrice($productInfos["price"]);
            $product->setStatus($productInfos["status"]);
            $product->setReference($productInfos["reference"]);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\BrandFixtures");
    }
}
