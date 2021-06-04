<?php


namespace App\UseCase\Customer\Update;

use App\Entity\Customer;
use App\Entity\Post;
use App\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Handler
 *
 * @package App\UseCase\Customer\Update
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
    )
    {
    }

    /**
     * @param Command $command
     *
     * @return Customer
     */
    public function handle(Command $command): Customer
    {
        /** @var Customer $customer */
        if (!$customer = $this->entityManager->find(Customer::class, $command->id)) {
            throw EntityNotFoundException::customerIsNotFound($command->id);
        }

        $customer
            ->setFirstName($command->firstName)
            ->setLastName($command->lastName)
            ->setEmail($command->email)
            ->setPhoneNumber($command->phoneNumber);

        $this->entityManager->flush();

        return $customer;
    }
}