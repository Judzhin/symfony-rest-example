<?php


namespace App\UseCase\Customer\Delete;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\UseCase\Customer\Delete
 */
class Command
{
    /**
     * Command constructor.
     *
     * @param string $id
     */
    public function __construct(
        #[Assert\NotBlank]
        public string $id
    )
    {}
}