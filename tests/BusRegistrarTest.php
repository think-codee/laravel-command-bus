<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests;


use Orchestra\Testbench\TestCase;
use ThinkCodee\Laravel\CommandBus\BusData;
use ThinkCodee\Laravel\CommandBus\BusRegistrar;
use ThinkCodee\Laravel\CommandBus\Exceptions\BusBindingException;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestBus;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestBusInterface;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestClass;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\TestInterface;

class BusRegistrarTest extends TestCase
{
    private BusRegistrar $busRegistrar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->busRegistrar = new BusRegistrar($this->app);
    }

    public function testItRegistersClassWithInterface(): void
    {
        $this->registerValidBus();

        $this->assertInstanceOf(TestBus::class, $this->app->make(TestBusInterface::class));
    }

    public function testItRegistersAlias(): void
    {
        $this->registerValidBus();

        $this->assertInstanceOf(TestBus::class, $this->app->make('command.bus.test'));
    }

    public function testItFailsWhenInvalidInterface(): void
    {
        $this->expectException(BusBindingException::class);

        $this->busRegistrar->register(
            new BusData(
                TestBus::class,
                TestInterface::class,
                [],
                'command.bus.test'
            )
        );
    }

    public function testItFailsHenInvalidClass(): void
    {
        $this->expectException(BusBindingException::class);

        $this->busRegistrar->register(
            new BusData(
                TestClass::class,
                TestInterface::class,
                [],
                'command.bus.test'
            )
        );
    }

    protected function registerValidBus(): void
    {
        $this->busRegistrar->register(
            new BusData(
                TestBus::class,
                TestBusInterface::class,
                [],
                'command.bus.test'
            )
        );
    }
}
