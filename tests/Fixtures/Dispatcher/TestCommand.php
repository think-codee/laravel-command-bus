<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Dispatcher;

use ThinkCodee\Laravel\CommandBus\Contracts\Command;

class TestCommand implements Command
{
    public function __construct(public int $value) {}
}
