<?php


namespace App\UseCase\Customer\Update;

use App\Entity\Customer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\UseCase\Customer\Update
 */
class Command extends \App\UseCase\Customer\Create\Command
{
    ///** @var string */
    //#[Assert\NotBlank]
    //public $firstName;
    //
    ///** @var string */
    //#[Assert\NotBlank]
    //public $lastName;
    //
    ///** @var string */
    //#[Assert\NotBlank]
    //public $email;
    //
    ///** @var string */
    //#[Assert\NotBlank]
    //public $phoneNumber;

    /**
     * Command constructor.
     * @param int $id
     */
    public function __construct(
        #[Assert\NotBlank]
        public int $id
    )
    {}

    /**
     * @param Customer $customer
     * @return static
     */
    public static function parse(Customer $customer): self
    {
        /** @var self $command */
        $command = new self($customer->getId());
        $command->firstName = $customer->getFirstName();
        $command->lastName = $customer->getLastName();
        $command->email = $customer->getEmail();
        $command->phoneNumber = $customer->getPhoneNumber();
        return $command;
    }
}