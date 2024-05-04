<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Dispatcher;

use Orchestra\Testbench\TestCase;
use ReflectionClass;
use ThinkCodee\Laravel\CommandBus\CommandDispatcher;
use ThinkCodee\Laravel\CommandBus\Exceptions\InvalidCommandHandlerException;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestCommandWithHandlerAttribute;

class CommandDispatcherHandlerValidationTest extends TestCase
{
    private CommandDispatcher $commandDispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandDispatcher = new CommandDispatcher($this->app);
    }

    public function testItFailsWhenMethodDoesNotExist(): void
    {
        $this->commandDispatcher
            ->handlerMethod('someMethod');

        $method = (new ReflectionClass($this->commandDispatcher))
            ->getMethod('getHandlerCallable');

        $method->setAccessible(true);

        $this->expectException(InvalidCommandHandlerException::class);

        $method->invoke($this->commandDispatcher, new TestCommandWithHandlerAttribute);
    }
}
