<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus;

use Illuminate\Contracts\Container\Container;
use ThinkCodee\Laravel\CommandBus\Contracts\CommandBus;
use ThinkCodee\Laravel\CommandBus\Exceptions\BusBindingException;

class BusRegistrar
{
    public function __construct(private Container $app) {}

    public function register(BusData $data): void
    {
        $this->validateInterface($data->interface, $data->class);
        $this->validateClass($data->class);

        $this->app->instance($data->interface, function (Container $app) use ($data) {
            return new $data->class(
                (new CommandDispatcher($app))
                    ->handlerResolver($data->handlerResolver)
                    ->handlerMethod($data->handlerMethod)
                    ->middleware($data->middleware)
            );
        });

        $this->app->alias($data->interface, $data->alias);
    }

    private function validateInterface(string $interface, string $class): void
    {
        if (!in_array(CommandBus::class, class_implements($interface))) {
            throw BusBindingException::invalidInterface($class, $interface);
        }
    }

    private function validateClass(string $class): void
    {
        if (!is_subclass_of($class, Bus::class)) {
            throw BusBindingException::invalidClass($class);
        }
    }
}
