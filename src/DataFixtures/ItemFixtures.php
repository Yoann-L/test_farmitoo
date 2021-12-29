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
        $orderRepository = $manager->getRepository("App\Entity\Order");
        $productRepository = $manager->getRepository("App\Entity\Product");

        $order = $orderRepository->findOneByReference("ERF25ER");
        $product1 = $productRepository->findOneByReference("ABCD1234");
        $product2 = $productRepository->findOneByReference("542424AZ");

        $items = [
            [
                "product" => $product1,
                "order" => $order,
                "quantity" => 10
            ],
            [
                "product" => $product2,
                "order" => $order,
                "quantity" => 1
            ]
        ];

        foreach ($items as $itemInfos) {
            $item = new Item();
            $item->setProduct($itemInfos["product"]);
            $item->setOrder($itemInfos["order"]);
            $item->setQuantity($itemInfos["quantity"]);

            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\ProductFixtures", "App\DataFixtures\OrderFixtures");
    }
}
