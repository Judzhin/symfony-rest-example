<?php


namespace App\ReadModel;


use App\Entity\Customer;
use App\Exception\EntityNotFoundException;
use App\Repository\CustomerRepository;

class CustomerFetcher
{
    /**
     * CustomerFetcher constructor.
     *
     * @param CustomerRepository $repository
     */
    public function __construct(
        private CustomerRepository  $repository
    )
    {
    }

    /**
     * @param string $id
     * @return Customer
     */
    public function find(string $id): Customer
    {
        /** @var Customer $customer */
        if (!$customer = $this->repository->find($id)) {
            throw EntityNotFoundException::customerIsNotFound($id);
        }

        return $customer;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return $this->repository->count([]);
    }
}