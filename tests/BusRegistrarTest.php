<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests;

use ThinkCodee\Laravel\CommandBus\BusData;
use ThinkCodee\Laravel\CommandBus\BusRegistrar;
use ThinkCodee\Laravel\CommandBus\Exceptions\BusBindingException;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Registrar\TestBus;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Registrar\TestBusInterface;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Registrar\TestInvalidBus;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Registrar\TestInvalidInterface;

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

    public function testItFailsWhenInterfaceDoesNotExists(): void
    {
        $this->expectException(BusBindingException::class);

        $this->busRegistrar->register(
            new BusData(
                TestBus::class,
                'InvalidInterface',
                [],
                'command.bus.test'
            )
        );
    }

    public function testItFailsWhenInvalidInterface(): void
    {
        $this->expectException(BusBindingException::class);

        $this->busRegistrar->register(
            new BusData(
                TestBus::class,
                TestInvalidInterface::class,
                [],
                'command.bus.test'
            )
        );
    }

    public function testItFailsWhenClassDoesNotExists(): void
    {
        $this->expectException(BusBindingException::class);

        $this->busRegistrar->register(
            new BusData(
                'InvalidClass',
                TestBusInterface::class,
                [],
                'command.bus.test'
            )
        );
    }

    public function testItFailsWhenInvalidClass(): void
    {
        $this->expectException(BusBindingException::class);

        $this->busRegistrar->register(
            new BusData(
                TestInvalidBus::class,
                TestInvalidInterface::class,
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
