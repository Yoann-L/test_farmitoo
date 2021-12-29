<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $users = [
            [
                "email" => "admin@gmail.com",
                "first_name" => "super",
                "last_name" => "admin",
            ]
        ];

        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                "email" => $faker->email,
                "first_name" => $faker->firstName,
                "last_name" => $faker->lastName,
            ];
        }

        foreach ($users as $userInfos) {
            $user = new User();
            $user->setEmail($userInfos["email"]);
            $user->setFirstName($userInfos["first_name"]);
            $user->setLastName($userInfos["last_name"]);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
