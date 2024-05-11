<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests;

use Illuminate\Support\Facades\Artisan;

class CommandBusServiceProviderTest extends TestCase
{
    public function testItRegistersCommands(): void
    {
        $commands = [
            'command-bus:make:command',
            'command-bus:make:bus'
        ];

        foreach ($commands as $command) {
            $this->assertArrayHasKey($command, Artisan::all());
        }
    }
}
