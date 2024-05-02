<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Exceptions;

use Exception;
use ThinkCodee\Laravel\CommandBus\Contracts\HandlerResolver;

class InvalidCommandHandlerResolverException extends Exception
{
    public static function emptyResolver(): static
    {
        return new static('No command handler resolver specified');
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
