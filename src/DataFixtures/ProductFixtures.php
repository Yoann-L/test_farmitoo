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
                "title" => "Cuve à gasoil",
                "price" => 250,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "ABCD1234"
            ],
            [
                "brand" => $brand1,
                "title" => "Nettoyant pour cuve",
                "price" => 5,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "253974EK"
            ],
            [
                "brand" => $brand2,
                "title" => "Piquet de clôture",
                "price" => 10,
                "status" => Product::PRODUCT_ENABLE,
                "reference" => "542424AZ"
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
