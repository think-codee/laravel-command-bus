<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Handler
{
    public string $handler;
    public ?string $method = null;

    public function __construct(string $handler, ?string $method = null)
    {
        $this->handler = $handler;
        $this->method = $method;
    }
}
