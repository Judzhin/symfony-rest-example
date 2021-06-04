<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var Generator $faker */
        $faker = Factory::create();

        /** @var int $i */
        for ($i = 0; $i < 50; $i++) {
            $customer = new Customer;
            $customer->setFirstName($faker->firstName());
            $customer->setLastName($faker->lastName());
            $customer->setEmail($faker->email());
            $customer->setPhoneNumber($faker->phoneNumber());
            $customer->setCreatedAt(new \DateTime);
            $manager->persist($customer);
        }

        $manager->flush();
    }
}
