<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Item;

class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $cartRepository = $manager->getRepository("App\Entity\Cart");
        $productRepository = $manager->getRepository("App\Entity\Product");

        $cart = $cartRepository->findOneByReference("LHPG523");
        $product1 = $productRepository->findOneByReference("ABCD1234");
        $product2 = $productRepository->findOneByReference("253974EK");
        $product3 = $productRepository->findOneByReference("542424AZ");

        $items = [
            [
                "product" => $product1,
                "cart" => $cart,
                "quantity" => 1
            ],
            [
                "product" => $product2,
                "cart" => $cart,
                "quantity" => 3
            ],
            [
                "product" => $product3,
                "cart" => $cart,
                "quantity" => 5
            ]
        ];

        foreach ($items as $itemInfos) {
            $item = new Item();
            $item->setProduct($itemInfos["product"]);
            $item->setCart($itemInfos["cart"]);
            $item->setQuantity($itemInfos["quantity"]);

            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\ProductFixtures", "App\DataFixtures\CartFixtures");
    }
}
