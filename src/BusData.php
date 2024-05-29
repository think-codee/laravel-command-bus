<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus;

class BusData
{
    public static function fromArray(array $data): static
    {
        return new static(
            $data['class'],
            $data['interface'],
            $data['middleware'],
            $data['alias'],
            $data['handler_resolver'],
            $data['handler_method']
        );
    }

    public function __construct(
        public string $class,
        public string $interface,
        public array $middleware,
        public string $alias,
        public ?string $handlerResolver = null,
        public ?string $handlerMethod = null,

    ) {}
}
