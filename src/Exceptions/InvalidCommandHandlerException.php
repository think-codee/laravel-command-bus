<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Exceptions;

use Exception;

class InvalidCommandHandlerException extends Exception
{
    public static function invalidMethod(string $handler, string $method): static
    {
        return new static(
            sprintf(
                '%s does not implement %s method',
                $handler,
                $method
            )
        );
    }
}
