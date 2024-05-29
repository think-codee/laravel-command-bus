<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Dispatcher;

use ThinkCodee\Laravel\CommandBus\Resolvers\SuffixHandlerResolver;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Dispatcher\TestCommand;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Dispatcher\TestMiddleware;

class CommandDispatcherTest extends CommandDispatcherTestCase
{
    public function testItRunsThroughMiddlewareAndExecutesCommand(): void
    {
        $this->assertEquals(
            2,
            $this->commandDispatcher
                ->middleware([TestMiddleware::class])
                ->handlerResolver(SuffixHandlerResolver::class)
                ->handlerMethod('handle')
                ->dispatchCommand(new TestCommand(1))
        );
    }
}
