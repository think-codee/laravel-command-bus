<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware;

use Closure;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;

class TestPrependMiddleware
{
    public function handle(Command $command, Closure $next): mixed
    {
        return $next($command);
    }
}
