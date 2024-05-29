<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus;

use ThinkCodee\Laravel\CommandBus\Contracts\Command;

abstract class Bus
{
    public function __construct(private CommandDispatcher $dispatcher) {}

    public function handle(Command $command): mixed
    {
        return $this->dispatcher->dispatchCommand($command);
    }
}
