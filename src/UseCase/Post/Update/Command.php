<?php


namespace App\UseCase\Post\Update;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package App\UseCase\Post\Update
 */
class Command
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    public $id;

    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    public $name;

    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    public $description;
}