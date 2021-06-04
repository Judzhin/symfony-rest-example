<?php


namespace App\UseCase\Customer\Delete;

use App\Entity\Customer;
use App\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Handler
 *
 * @package App\UseCase\Customer\Delete
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
     */
    public function handle(Command $command): void
    {
        /** @var Customer $customer */
        if (!$customer = $this->entityManager->find(Customer::class, $command->id)) {
            throw EntityNotFoundException::customerIsNotFound($command->id);
        }

        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }
}