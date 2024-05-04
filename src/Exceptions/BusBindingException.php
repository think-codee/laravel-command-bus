<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Exceptions;

use Exception;
use ThinkCodee\Laravel\CommandBus\Bus;
use ThinkCodee\Laravel\CommandBus\Contracts\CommandBus;

class BusBindingException extends Exception
{
    public static function interfaceDoesNotExists(string $bus, string $interface): static
    {
        return new static(
            sprintf(
                'The given interface %s of %s does not exist.',
                $interface,
                $bus
            )
        );
    }

    public static function invalidInterface(string $bus, string $interface): static
    {
        return new static(
            sprintf(
                'The interface of %s should extend %s interface, %s given',
                $bus,
                CommandBus::class,
                $interface
            )
        );
    }

    public static function classDoesNotExists(string $bus): static
    {
        return new static(
            sprintf(
                'The given bus class %s does not exist.',
                $bus
            )
        );
    }

    public static function invalidClass(string $bus): static
    {
        return new static(
            sprintf(
                'The %s should extend %s',
                $bus,
                Bus::class
            )
        );
    }
}
