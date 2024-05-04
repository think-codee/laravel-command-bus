<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests;

use Orchestra\Testbench\TestCase;
use ThinkCodee\Laravel\CommandBus\Exceptions\HandlerResolvingException;
use ThinkCodee\Laravel\CommandBus\Resolvers\SuffixHandlerResolver;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\SuffixResolver\TestCommand;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\SuffixResolver\TestCommandHandler;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\SuffixResolver\TestOtherCommand;

class SuffixHandlerResolverTest extends TestCase
{
    private SuffixHandlerResolver $handlerResolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handlerResolver = $this->app->make(SuffixHandlerResolver::class);
    }

    public function testItResolvesHandler(): void
    {
        $this->assertInstanceOf(
            TestCommandHandler::class,
            $this->handlerResolver->resolve(new TestCommand)
        );
    }

    public function testItFailsWhenInvalidHandler(): void
    {
        $this->expectException(HandlerResolvingException::class);

        $this->assertInstanceOf(
            'No handler',
            $this->handlerResolver->resolve(new TestOtherCommand)
        );
    }
}
