<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Commands;

class GenerateBusTest extends GeneratorCommandTestCase
{
    public function testItGeneratesBusWithInterface(): void
    {
        $busName = 'Test';

        $this->artisan('command-bus:make:bus', ['name' => $busName])
            ->expectsOutput('Bus created successfully!')
            ->assertSuccessful();

        $this->assertFileExists(app_path("Buses/$busName/{$busName}Bus.php"));
        $this->assertFileExists(app_path("Buses/$busName/{$busName}Interface.php"));
    }

    public function testItFailsWhenBusExists(): void
    {
        $busName = 'Test';

        $this->artisan('command-bus:make:bus', ['name' => $busName])
            ->expectsOutput('Bus created successfully!')
            ->assertSuccessful();

        $this->artisan('command-bus:make:bus', ['name' => $busName])
            ->expectsOutput('Bus already exists!')
            ->assertFailed();
    }

    protected function getTeardownDirectories(): array
    {
        return [
            app_path('Buses')
        ];
    }
}
