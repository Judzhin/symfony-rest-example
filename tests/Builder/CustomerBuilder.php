<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Entity\Customer;
use Faker\Factory;
use PHPUnit\Framework\MockObject\Generator;

/**
 * Class CustomerBuilder
 *
 * @package App\Tests\Builder
 */
class CustomerBuilder
{
    /** @var int */
    private int $id;

    /** @var string */
    private string $firstName;

    /** @var string */
    private string $lastName;

    /** @var string */
    private string $email;

    /** @var string */
    private string $phoneNumber;

    /** @var \DateTime */
    private \DateTime $createdAt;

    /**
     * CustomerBuilder constructor.
     */
    public function __construct()
    {
        /** @var Generator $faker */
        $faker = Factory::create();
        $this->id = 1;
        $this->firstName = $faker->firstName();
        $this->lastName = $faker->lastName();
        $this->email = $faker->email();
        $this->phoneNumber = $faker->phoneNumber();
        $this->createdAt = new \DateTime;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function withId(int $id): self
    {
        $clone = clone $this;
        $clone->id = $id;
        return $clone;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function withFirstName(string $firstName): self
    {
        $clone = clone $this;
        $clone->firstName = $firstName;
        return $clone;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function withLastName(string $lastName): self
    {
        $clone = clone $this;
        $clone->lastName = $lastName;
        return $clone;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function withEmail(string $email): self
    {
        $clone = clone $this;
        $clone->email = $email;
        return $clone;
    }

    /**
     * @param string $phoneNumber
     * @return $this
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $clone = clone $this;
        $clone->phoneNumber = $phoneNumber;
        return $clone;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function withCreatedAt(\DateTime $createdAt): self
    {
        $clone = clone $this;
        $clone->createdAt = $createdAt;
        return $clone;
    }

    /**
     * @return Customer
     */
    public function build(): Customer
    {
        return (new Customer)
            ->setId($this->id)
            ->setFirstName($this->firstName)
            ->setLastName($this->lastName)
            ->setEmail($this->email)
            ->setPhoneNumber($this->phoneNumber)
            ->setCreatedAt($this->createdAt);
    }
}