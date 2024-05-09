<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests;

use Illuminate\Support\Facades\Artisan;

class CommandBusServiceProviderTest extends TestCase
{
    public function testItRegistersCommands(): void
    {
        $this->assertArrayHasKey('command-bus:make:command', Artisan::all());
    }
}
