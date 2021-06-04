<?php


namespace App\UseCase\Customer\Update;

use App\Entity\Customer;
use App\Entity\Post;
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
    ) {}

    /**
     * @param Command $command
     *
     * @return Customer
     */
    public function handle(Command $command): Customer
    {


        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }
}