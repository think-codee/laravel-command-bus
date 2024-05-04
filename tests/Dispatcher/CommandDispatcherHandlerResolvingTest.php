<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Dispatcher;

use ReflectionClass;
use ReflectionMethod;
use ThinkCodee\Laravel\CommandBus\Exceptions\HandlerResolvingException;
use ThinkCodee\Laravel\CommandBus\Exceptions\InvalidCommandHandlerResolverException;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler\TestCommand;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler\TestCommandWithHandlerAttribute;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler\TestCommandWithHandlerAttributeHandler;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler\TestCommandWithInvalidHandlerAttribute;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler\TestInvalidHandlerResolver;

class CommandDispatcherHandlerResolvingTest extends CommandDispatcherTestCase
{
    public function testItResolvesHandlerFromAttribute(): void
    {
        $method = $this->getHandlerMethod();

        $this->assertInstanceOf(
            TestCommandWithHandlerAttributeHandler::class,
            $method->invoke($this->commandDispatcher, new TestCommandWithHandlerAttribute())
        );
    }

    public function testItFailsWhenInvalidHandlerAttribute(): void
    {
        $method = $this->getHandlerMethod();

        $this->expectException(HandlerResolvingException::class);

        $this->assertInstanceOf(
            'CommandHandler',
            $method->invoke($this->commandDispatcher, new TestCommandWithInvalidHandlerAttribute())
        );
    }

    public function testItFailsWhenInvalidHandlerResolver(): void
    {
        $this->commandDispatcher->handlerResolver(TestInvalidHandlerResolver::class);

        $method = $this->getHandlerMethod();

        $this->expectException(InvalidCommandHandlerResolverException::class);

        $this->assertInstanceOf(
            'CommandHandler',
            $method->invoke($this->commandDispatcher, new TestCommand())
        );
    }

    public function testItFailsWhenHandlerResolverNotFound(): void
    {
        $this->commandDispatcher->handlerResolver('InvalidHandlerResolver');

        $method = $this->getHandlerMethod();

        $this->expectException(InvalidCommandHandlerResolverException::class);

        $this->assertInstanceOf(
            TestCommandWithHandlerAttributeHandler::class,
            $method->invoke($this->commandDispatcher, new TestCommand())
        );
    }

    private function getHandlerMethod(): ReflectionMethod
    {
        $method = (new ReflectionClass($this->commandDispatcher))->getMethod('getHandler');

        $method->setAccessible(true);

        return $method;
    }
}
