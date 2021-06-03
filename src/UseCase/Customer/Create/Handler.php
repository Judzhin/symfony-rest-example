<?php


namespace App\UseCase\Customer\Create;

use App\Entity\Customer;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Handler
 *
 * @package App\UseCase\Customer\Create
 */
class Handler
{
    /**
     * Handler constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @param Command $command
     *
     * @return Customer
     */
    public function handle(Command $command): Customer
    {
        /** @var Customer $customer */
        $customer = (new Customer)
            ->setFirstName($command->firstName)
            ->setLastName($command->lastName)
            ->setEmail($command->email)
            ->setPhoneNumber($command->phoneNumber);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }
}