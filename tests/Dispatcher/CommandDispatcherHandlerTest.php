<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Dispatcher;

use Orchestra\Testbench\TestCase;
use ReflectionClass;
use ThinkCodee\Laravel\CommandBus\CommandDispatcher;
use ThinkCodee\Laravel\CommandBus\Resolvers\SuffixHandlerResolver;

class CommandDispatcherHandlerTest extends TestCase
{
    private CommandDispatcher $commandDispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandDispatcher = new CommandDispatcher($this->app);
    }

    public function testItSetsHandlerResolver(): void
    {
        $this->commandDispatcher
            ->handlerResolver(SuffixHandlerResolver::class);

        $resolverProperty = (new ReflectionClass($this->commandDispatcher))
            ->getProperty('handlerResolver');

        $resolverProperty->setAccessible(true);

        $this->assertEquals(
            SuffixHandlerResolver::class,
            $resolverProperty->getValue($this->commandDispatcher)
        );
    }

    public function testItSetsDefaultHandlerResolver(): void
    {
        $this->commandDispatcher
            ->handlerResolver(null);

        $resolverProperty = (new ReflectionClass($this->commandDispatcher))
            ->getProperty('handlerResolver');

        $resolverProperty->setAccessible(true);

        $this->assertEquals(
            SuffixHandlerResolver::class,
            $resolverProperty->getValue($this->commandDispatcher)
        );
    }

    public function testItSetsHandlerMethod(): void
    {
        $this->commandDispatcher
            ->handlerMethod('test');

        $resolverProperty = (new ReflectionClass($this->commandDispatcher))
            ->getProperty('handlerMethod');

        $resolverProperty->setAccessible(true);

        $this->assertEquals(
            'test',
            $resolverProperty->getValue($this->commandDispatcher)
        );
    }

    public function testItSetsDefaultHandlerMethod(): void
    {
        $this->commandDispatcher
            ->handlerMethod(null);

        $resolverProperty = (new ReflectionClass($this->commandDispatcher))
            ->getProperty('handlerMethod');

        $resolverProperty->setAccessible(true);

        $this->assertEquals(
            'handle',
            $resolverProperty->getValue($this->commandDispatcher)
        );
    }
}
