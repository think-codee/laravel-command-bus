<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus;

use Closure;
use Illuminate\Contracts\Container\Container;
use ReflectionClass;
use ThinkCodee\Laravel\CommandBus\Attributes\Handler;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;
use ThinkCodee\Laravel\CommandBus\Contracts\HandlerResolver;
use ThinkCodee\Laravel\CommandBus\Exceptions\InvalidCommandHandlerException;
use ThinkCodee\Laravel\CommandBus\Exceptions\InvalidCommandHandlerResolverException;
use ThinkCodee\Laravel\CommandBus\Handler\SuffixHandlerResolver;

class CommandDispatcher
{
    protected array $middleware = [];

    protected string $handlerResolver;

    protected string $handlerMethod;

    public function __construct(private Container $app) {}

    public function dispatchCommand(Command $command): mixed
    {
    }

    public function handlerResolver(?string $handlerResolver = null): static
    {
        $this->handlerResolver = $handlerResolver ?? SuffixHandlerResolver::class;

        return $this;
    }

    public function handlerMethod(?string $handlerMethod = null): static
    {
        $this->handlerMethod = $handlerMethod ?? 'handle';

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

    public function getHandlerCallable(Command $command): callable
    {
       $handler = $this->getHandler($command);
       $method = $this->getMethod($command);

       $this->validateCallable($handler, $method);

       return [$handler, $method];
    }

    private function getHandler(Command $command): object
    {
        $attributes = (new ReflectionClass($command))
            ->getAttributes(Handler::class);

        return empty($attributes) ? $this->resolveHandler($command) : $attributes[0]->newInstance()->handler;
    }

    private function resolveHandler(Command $command): object
    {
        if (!in_array(HandlerResolver::class, class_implements($this->handlerResolver))) {
            throw InvalidCommandHandlerResolverException::mustImplementInterface($this->handlerResolver);
        }

        return $this->app->make($this->handlerResolver)->resolve($command);
    }

    private function getMethod(Command $command)
    {
        $attributes = (new ReflectionClass($command))
            ->getAttributes(Handler::class);

        return empty($attributes) || !$attributes[0]->newInstance()->method
            ? $this->handlerMethod
            : $attributes[0]->newInstance()->method;
    }

    private function validateCallable(object $handler, string $method): void
    {
        if (!method_exists($handler, $method)) {
            throw InvalidCommandHandlerException::invalidMethod($handler::class, $method);
        }
    }
}
