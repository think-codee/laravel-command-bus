<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Dispatcher;

use ReflectionClass;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware\TestAppendMiddleware;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware\TestCommandHandlerWithMiddlewareAttribute;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware\TestCommandWithEmptyMiddlewareHandlerAttributeHandler;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware\TestMiddleware;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware\TestPrependMiddleware;

class CommandDispatcherMiddlewareTest extends CommandDispatcherTestCase
{
    public function testItSetsMiddleware(): void
    {
        $this->commandDispatcher->middleware([TestMiddleware::class]);

        $property = (new ReflectionClass($this->commandDispatcher))->getProperty('middleware');

        $property->setAccessible(true);

        $this->assertEquals(
            [TestMiddleware::class],
            $property->getValue($this->commandDispatcher)
        );
    }

    public function testItRemovesMiddlewareWhenAttributePresent(): void
    {
        $this->commandDispatcher
            ->middleware(TestMiddleware::class);

        $getMiddleware = (new ReflectionClass($this->commandDispatcher))->getMethod('getMiddleware');

        $getMiddleware->setAccessible(true);

        $this->assertEquals(
            [],
            $getMiddleware->invoke(
                $this->commandDispatcher,
                [new TestCommandWithEmptyMiddlewareHandlerAttributeHandler, 'handle']
            )
        );
    }

    public function testItSetsMiddlewareFromAttribute(): void
    {
        $this->commandDispatcher
            ->middleware(TestMiddleware::class);

        $getMiddleware = (new ReflectionClass($this->commandDispatcher))->getMethod('getMiddleware');

        $getMiddleware->setAccessible(true);

        $this->assertEquals(
            [
                TestPrependMiddleware::class,
                TestMiddleware::class,
                TestAppendMiddleware::class
            ],
            $getMiddleware->invoke(
                $this->commandDispatcher,
                [new TestCommandHandlerWithMiddlewareAttribute, 'handle']
            )
        );
    }
}
