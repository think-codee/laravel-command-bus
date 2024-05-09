<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Commands;

use Illuminate\Support\Facades\File;
use ThinkCodee\Laravel\CommandBus\Tests\TestCase;

class GenerateCommandTest extends TestCase
{
    private const STUB_PATH = __DIR__ . '/../../stubs';

    protected function tearDown(): void
    {
        File::shouldReceive('delete')
            ->andReturnTrue();

        File::delete([
            app_path('Commands/TestCommand.php'),
            app_path('Commands/TestCommandHandler.php'),
        ]);

        parent::tearDown();
    }

    public function testItGeneratesCommandWithHandler(): void
    {
        $commandName = 'Test';

        $this->mockCommandAndHandlerGeneration();

        $this->artisan('command-bus:make:command', ['name' => $commandName])
            ->assertSuccessful()
            ->run();

        $this->assertFileExists(app_path("Commands/Test/$commandName.php"));
        $this->assertFileExists(app_path("Commands/Test/{$commandName}Handler.php"));
    }

    public function testItFailsWhenCommandExists(): void
    {
        $commandName = 'Test';

        File::shouldReceive('exists')
            ->with(app_path("Commands/$commandName"))
            ->andReturnTrue();

        $this->artisan('command-bus:make:command', ['name' => $commandName])
            ->assertFailed()
            ->run();

        File::shouldReceive('exists')
            ->andReturnFalse();

        $this->assertFileDoesNotExist(app_path("Commands/Test/$commandName.php"));
        $this->assertFileDoesNotExist(app_path("Commands/Test/{$commandName}Handler.php"));
    }

    private function mockCommandAndHandlerGeneration(): void
    {
        File::shouldReceive('exists')
            ->andReturn(false);

        File::shouldReceive('makeDirectory')
            ->andReturn(true);

        File::shouldReceive('get')
            ->once()
            ->andReturn(self::STUB_PATH.'/command.stub');

        File::shouldReceive('get')
            ->once()
            ->andReturn(self::STUB_PATH.'/handler.stub');

        File::shouldReceive('put')
            ->twice()
            ->andReturn(true);
    }
}
