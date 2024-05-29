<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Contracts;

interface CommandBus
{
    public function handle(Command $command): mixed;
}
