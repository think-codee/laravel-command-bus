<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus;

use Closure;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;

class CommandDispatcher
{
    protected array $middleware = [];

    protected string $handlerResolver;

    protected string $handlerMethodResolver;

    public function dispatchCommand(Command $command): mixed
    {
    }

    public function handlerResolver(string $handlerResolver): static
    {
        $this->handlerResolver = $handlerResolver;

        return $this;
    }

    public function handlerMethodResolver(string $handlerMethodResolver): static
    {
        $this->handlerMethodResolver = $handlerMethodResolver;

        return $this;
    }

    public function middleware(string|callable|Closure|array $middleware): static
    {
        if (!is_array($middleware)) {
            $middleware = [$middleware];
        }

        $this->middleware = $middleware;

        return $this;
    }
}
