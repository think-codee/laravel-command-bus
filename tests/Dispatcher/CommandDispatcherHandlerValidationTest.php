<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Dispatcher;

use ReflectionClass;
use ThinkCodee\Laravel\CommandBus\Exceptions\InvalidCommandHandlerException;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherHandler\TestCommandWithHandlerAttribute;

class CommandDispatcherHandlerValidationTest extends CommandDispatcherTestCase
{
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
