<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Order;
use DateTimeImmutable;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $userRepository = $manager->getRepository("App\Entity\User");

        $user = $userRepository->findOneByEmail("admin@gmail.com");

        $orders = [
            [
                "delivery_address" => $user->getAddresses()[0],
                "billing_address" => $user->getAddresses()[0],
                "user" => $user,
                "status" => Order::ORDER_STATUS_PAID,
                "created_at" => new DateTimeImmutable("NOW"),
            ]
        ];

        foreach ($orders as $orderInfos) {
            $order = new Order();
            $order->setDeliveryAddress($orderInfos["delivery_address"]);
            $order->setBillingAddress($orderInfos["billing_address"]);
            $order->setUser($orderInfos["user"]);
            $order->setStatus($orderInfos["status"]);
            $order->setCreatedAt($orderInfos["created_at"]);

            $manager->persist($order);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array("App\DataFixtures\UserFixtures", "App\DataFixtures\AddressFixtures");
    }
}
