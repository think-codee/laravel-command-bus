<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Exceptions;

use Exception;

class HandlerResolvingException extends Exception
{
    public static function handlerDoesNotExists(string $handler): static
    {
        return new static(
            sprintf(
                'Handler %s does not exists',
                $handler
            )
        );
    }
}
