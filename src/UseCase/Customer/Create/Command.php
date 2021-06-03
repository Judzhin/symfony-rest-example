<?php


namespace App\UseCase\Customer\Create;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\UseCase\Customer\Create
 */
class Command
{
    /** @var string */
    #[Assert\NotBlank]
    public $firstName;

    /** @var string */
    #[Assert\NotBlank]
    public $lastName;

    /** @var string */
    #[Assert\NotBlank]
    public $email;

    /** @var string */
    #[Assert\NotBlank]
    public $phoneNumber;
}