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
            ->build();

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals($customer->getId(), $id);
        $this->assertEquals($customer->getFirstName(), $firstName);
    }
}