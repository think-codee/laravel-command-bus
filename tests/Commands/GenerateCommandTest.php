<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Commands;

class GenerateCommandTest extends GeneratorCommandTestCase
{
    public function testItGeneratesCommandWithHandler(): void
    {
        $commandName = 'Test';

        $this->artisan('command-bus:make:command', ['name' => $commandName])
            ->expectsOutput('Command created successfully!')
            ->assertSuccessful();

        $this->assertFileExists(app_path("Commands/$commandName/$commandName.php"));
        $this->assertFileExists(app_path("Commands/$commandName/{$commandName}Handler.php"));
    }

    public function testItFailsWhenCommandExists(): void
    {
        $commandName = 'Test';

        $this->artisan('command-bus:make:command', ['name' => $commandName])
            ->expectsOutput('Command created successfully!')
            ->assertSuccessful()
            ->run();

        $this->artisan('command-bus:make:command', ['name' => $commandName])
            ->expectsOutput('Command already exists!')
            ->assertFailed()
            ->run();
    }

    protected function getTeardownDirectories(): array
    {
        return [
            app_path('Commands'),
        ];
    }
}
