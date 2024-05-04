<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Dispatcher;

use ReflectionClass;
use ReflectionMethod;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler\TestCommand;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler\TestCommandWithHandlerAttribute;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler\TestCommandWithHandlerAndMethodAttribute;

class CommandDispatcherHandlerMethodResolvingTest extends CommandDispatcherTestCase
{
    public function testItResolvesMethodFromAttribute()
    {
        $method = $this->getMethod();

        $this->assertEquals(
            'customMethod',
            $method->invoke($this->commandDispatcher, new TestCommandWithHandlerAndMethodAttribute)
        );
    }

    public function testItResolvesWithConfigValueWhenMethodNotSpecified(): void
    {
        $this->commandDispatcher->handlerMethod('someMethod');

        $method = $this->getMethod();

        $this->assertEquals(
            'someMethod',
            $method->invoke($this->commandDispatcher, new TestCommandWithHandlerAttribute)
        );
    }

    public function testItResolvesWithConfigValueWhenNoAttribute()
    {
        $this->commandDispatcher->handlerMethod('someMethod');

        $method = $this->getMethod();

        $this->assertEquals(
            'someMethod',
            $method->invoke($this->commandDispatcher, new TestCommand)
        );
    }

    private function getMethod(): ReflectionMethod
    {
        $method = (new ReflectionClass($this->commandDispatcher))->getMethod('getMethod');

        $method->setAccessible(true);

        return $method;
    }
}
