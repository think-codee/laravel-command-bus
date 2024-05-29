<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Dispatcher;

use Closure;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;

class TestMiddleware
{
    public function handle(Command $command, Closure $next): mixed
    {
        $command->value++;

        return $next($command);
    }
}
