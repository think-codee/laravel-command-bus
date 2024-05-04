<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS|Attribute::IS_REPEATABLE)]
class Middleware
{
    public array $middleware;

    public bool $prepend;

    public function __construct(?array $middleware = [], ?bool $prepend = false)
    {
        $this->middleware = $middleware;
        $this->prepend = $prepend;
    }
}
