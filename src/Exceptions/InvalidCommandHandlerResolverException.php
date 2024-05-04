<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Exceptions;

use Exception;
use ThinkCodee\Laravel\CommandBus\Contracts\HandlerResolver;

class InvalidCommandHandlerResolverException extends Exception
{
    public static function handlerResolverDoesNotExists(string $resolver): static
    {
        return new static(
            sprintf('%s does not exists', $resolver)
        );
    }

    public static function mustImplementInterface(string $resolver): static
    {
        return new static(
            sprintf(
                '%s must implement the %s interface',
                $resolver,
                HandlerResolver::class
            )
        );
    }
}
