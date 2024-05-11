<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Commands;

use Illuminate\Support\Facades\File;
use ThinkCodee\Laravel\CommandBus\Tests\TestCase;

class GenerateCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        File::deleteDirectory(app_path('Commands'));

        parent::tearDown();
    }

    public function testItGeneratesCommandWithHandler(): void
    {
        $commandName = 'Test';

        $this->artisan('command-bus:make:command', ['name' => $commandName])
            ->assertSuccessful();

        $this->assertFileExists(app_path("Commands/$commandName/$commandName.php"));
        $this->assertFileExists(app_path("Commands/$commandName/{$commandName}Handler.php"));
    }

    public function testItFailsWhenCommandExists(): void
    {
        $commandName = 'Test';

        $this->artisan('command-bus:make:command', ['name' => $commandName])
            ->assertSuccessful()
            ->run();

        $this->artisan('command-bus:make:command', ['name' => $commandName])
            ->assertFailed()
            ->run();
    }
}
