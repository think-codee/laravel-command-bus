<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Dispatcher;

use Orchestra\Testbench\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ThinkCodee\Laravel\CommandBus\CommandDispatcher;
use ThinkCodee\Laravel\CommandBus\Exceptions\HandlerResolvingException;
use ThinkCodee\Laravel\CommandBus\Exceptions\InvalidCommandHandlerResolverException;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestCommand;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestCommandWithHandlerAttribute;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestCommandWithInvalidHandlerAttribute;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestCustomCommandHandler;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestInvalidHandlerResolver;

class CommandDispatcherHandlerResolvingTest extends TestCase
{
    private CommandDispatcher $commandDispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandDispatcher = new CommandDispatcher($this->app);
    }

    public function testItResolvesHandlerFromAttribute(): void
    {
        $method = $this->getHandlerMethod();

        $this->assertInstanceOf(
            TestCustomCommandHandler::class,
            $method->invoke($this->commandDispatcher, new TestCommandWithHandlerAttribute())
        );
    }

    public function testItFailsWhenInvalidHandlerAttribute(): void
    {
        $method = $this->getHandlerMethod();

        $this->expectException(HandlerResolvingException::class);

        $this->assertInstanceOf(
            TestCustomCommandHandler::class,
            $method->invoke($this->commandDispatcher, new TestCommandWithInvalidHandlerAttribute())
        );
    }

    public function testItFailsWhenInvalidHandlerResolver(): void
    {
        $this->commandDispatcher->handlerResolver(TestInvalidHandlerResolver::class);

        $method = $this->getHandlerMethod();

        $this->expectException(InvalidCommandHandlerResolverException::class);

        $this->assertInstanceOf(
            TestCustomCommandHandler::class,
            $method->invoke($this->commandDispatcher, new TestCommand(1))
        );
    }

    public function testItFailsWhenHandlerResolverNotFound(): void
    {
        $this->commandDispatcher->handlerResolver('some invalid');

        $method = $this->getHandlerMethod();

        $this->expectException(InvalidCommandHandlerResolverException::class);

        $this->assertInstanceOf(
            TestCustomCommandHandler::class,
            $method->invoke($this->commandDispatcher, new TestCommand(1))
        );
    }

    private function getHandlerMethod(): ReflectionMethod
    {
        $method = (new ReflectionClass($this->commandDispatcher))->getMethod('getHandler');

        $method->setAccessible(true);

        return $method;
    }
}
