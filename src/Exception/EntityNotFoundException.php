<?php


namespace App\Exception;

use JetBrains\PhpStorm\Pure;

/**
 * Class EntityNotFoundException
 * @package App\Exception
 */
class EntityNotFoundException extends \LogicException
{
    /**
     * @param string $className
     * @param string $id
     * @return static
     */
    #[Pure] private static function entityIsNotFound(string $className, string $id): self
    {
        return new self(sprintf('%s "%s" is not found.', $className, $id));
    }

    /**
     * @param string $id
     * @return static
     */
    #[Pure] public static function customerIsNotFound(string $id): self
    {
        return self::entityIsNotFound('Customer', $id);
    }
}