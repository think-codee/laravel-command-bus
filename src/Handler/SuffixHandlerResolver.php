<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Handler;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Str;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;
use ThinkCodee\Laravel\CommandBus\Contracts\HandlerResolver;

class SuffixHandlerResolver implements HandlerResolver
{
    public function __construct(private Container $app) {}

    public function resolve(Command $command): object
    {
        $class = $this->resolveClassName($command);

        return $this->app->make($class);
    }

    private function resolveClassName(Command $command): string
    {
        return Str::studly(sprintf(`%s %s`, $command::class, 'handler'));
    }
}
