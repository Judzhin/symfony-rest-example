<?php


namespace App\ReadModel;


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