<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware;

use Closure;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;

class TestAppendMiddleware
{
    public function handle(Command $command, Closure $next): mixed
    {
        return $next($command);
    }
}
