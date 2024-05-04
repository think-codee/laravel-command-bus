<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Dispatcher;

use Orchestra\Testbench\TestCase;
use ThinkCodee\Laravel\CommandBus\CommandDispatcher;

class CommandDispatcherTestCase extends TestCase
{
    protected CommandDispatcher $commandDispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandDispatcher = new CommandDispatcher($this->app);
    }
}
