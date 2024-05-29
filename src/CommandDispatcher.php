<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus;

use Closure;
use Illuminate\Contracts\Container\Container;
use ReflectionClass;
use ThinkCodee\Laravel\CommandBus\Attributes\ResetMiddleware;
use ThinkCodee\Laravel\CommandBus\Attributes\Handler;
use ThinkCodee\Laravel\CommandBus\Attributes\Middleware;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;
use ThinkCodee\Laravel\CommandBus\Contracts\HandlerResolver;
use ThinkCodee\Laravel\CommandBus\Exceptions\HandlerResolvingException;
use ThinkCodee\Laravel\CommandBus\Exceptions\InvalidCommandHandlerException;
use ThinkCodee\Laravel\CommandBus\Exceptions\InvalidCommandHandlerResolverException;
use ThinkCodee\Laravel\CommandBus\Resolvers\SuffixHandlerResolver;
use Illuminate\Support\Facades\Pipeline;

class CommandDispatcher
{
    protected array $middleware = [];

    protected string $handlerResolver;

    protected string $handlerMethod;

    public function __construct(private Container $app) {}

    public function dispatchCommand(Command $command): mixed
    {
        $callable = $this->getHandlerCallable($command);

        return Pipeline::send($command)
            ->through($this->getMiddleware($callable))
            ->then(fn (Command $command) => $this->app->call($callable, compact('command')));
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

    protected function getMiddleware(callable $callable): array
    {
        $middleware = $this->middleware;

        [$handler] = $callable;

        $reflection = new ReflectionClass($handler);

        if (!empty($reflection->getAttributes(ResetMiddleware::class))) {
            $middleware = [];
        }

        return $this->addHandlerMiddleware(
            $middleware,
            $reflection->getAttributes(Middleware::class)
        );
    }

    protected function addHandlerMiddleware(array $middleware, array $attributes): array
    {
        foreach ($attributes as $attribute) {
            $instance = $attribute->newInstance();

            if ($instance->prepend) {
                $middleware = array_merge($instance->middleware, $middleware);
            } else {
                $middleware = array_merge($middleware, $instance->middleware);
            }
        }

        return $middleware;
    }

    protected function getHandlerCallable(Command $command): callable
    {
       $handler = $this->getHandler($command);
       $method = $this->getMethod($command);

       $this->validateCallable($handler, $method);

       return [$handler, $method];
    }

    protected function getHandler(Command $command): object
    {
        $attributes = (new ReflectionClass($command))
            ->getAttributes(Handler::class);

        return empty($attributes)
            ? $this->resolveHandler($command)
            : $this->instantiateHandlerFromAttributes($attributes);
    }

    protected function instantiateHandlerFromAttributes(array $attributes): object
    {
        $handler = $attributes[0]->newInstance()->handler;

        if (!class_exists($handler)) {
            throw HandlerResolvingException::handlerDoesNotExists($handler);
        }

        return $this->app->make($handler);
    }

    protected function resolveHandler(Command $command): object
    {
        if (!class_exists($this->handlerResolver)) {
            throw InvalidCommandHandlerResolverException::handlerResolverDoesNotExists($this->handlerResolver);
        }

        if (!in_array(HandlerResolver::class, class_implements($this->handlerResolver))) {
            throw InvalidCommandHandlerResolverException::mustImplementInterface($this->handlerResolver);
        }

        return $this->app->make($this->handlerResolver)->resolve($command);
    }

    protected function getMethod(Command $command)
    {
        $attributes = (new ReflectionClass($command))
            ->getAttributes(Handler::class);

        return empty($attributes) || !$attributes[0]->newInstance()->method
            ? $this->handlerMethod
            : $attributes[0]->newInstance()->method;
    }

    protected function validateCallable(object $handler, string $method): void
    {
        if (!method_exists($handler, $method)) {
            throw InvalidCommandHandlerException::invalidMethod($handler::class, $method);
        }
    }
}
