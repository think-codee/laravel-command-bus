<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Handler;

use ThinkCodee\Laravel\CommandBus\Contracts\Command;
use ThinkCodee\Laravel\CommandBus\Contracts\HandlerResolver;

class SuffixHandlerResolver implements HandlerResolver
{
    public function resolve(Command $command): object
    {
        // TODO: Implement resolve() method.
    }
}
