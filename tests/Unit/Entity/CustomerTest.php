<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Customer;
use App\Tests\Builder\CustomerBuilder;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomerTest
 * @package App\Tests\Unit\Entity
 */
class CustomerTest extends TestCase
{
    public function testSuccess(): void
    {
        /** @var Generator $faker */
        $faker = Factory::create();
        /** @var Customer $customer */
        $customer = (new CustomerBuilder)
            ->withId($id = 1)
            ->withFirstName($firstName = $faker->firstName())
            ->withLastName($lastName = $faker->lastName())
            ->withEmail($email = $faker->email())
            ->withPhoneNumber($phoneNumber = $faker->phoneNumber())
            ->withCreatedAt($createdAt = new \DateTime)
            ->build();

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals($customer->getId(), $id);
        $this->assertEquals($customer->getFirstName(), $firstName);
        $this->assertEquals($customer->getLastName(), $lastName);
        $this->assertEquals($customer->getEmail(), $email);
        $this->assertEquals($customer->getPhoneNumber(), $phoneNumber);
        $this->assertInstanceOf(\DateTime::class, $customer->getCreatedAt());
        $this->assertEquals($customer->getCreatedAt(), $createdAt);
    }
}