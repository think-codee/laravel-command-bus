<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests;

use ThinkCodee\Laravel\CommandBus\CommandBusServiceProvider;
use ThinkCodee\Laravel\CommandBus\Resolvers\SuffixHandlerResolver;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Provider\TestBus;
use ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Provider\TestInterface;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('command_bus', [
            'buses' => [
                'default' => [
                    'class' => TestBus::class,
                    'interface' => TestInterface::class,
                    'alias' => 'bus.test',
                    'middleware' => [],
                    'handler_resolver' => SuffixHandlerResolver::class,
                    'handler_method' => 'handle',
                ],
            ]
        ]);
    }

    protected function getPackageProviders($app): array
    {
        return [
            CommandBusServiceProvider::class
        ];
    }
}
