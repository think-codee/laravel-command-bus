<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures;

use ThinkCodee\Laravel\CommandBus\Contracts\Command;
use ThinkCodee\Laravel\CommandBus\Contracts\HandlerResolver;

class TestHandlerResolver implements HandlerResolver
{
    public function resolve(Command $command): object
    {
        return new TestCommandHandler();
    }
}
