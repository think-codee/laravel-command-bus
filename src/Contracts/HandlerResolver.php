<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Contracts;

interface HandlerResolver
{
    public function resolve(Command $command): object;
}
