<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Commands;

class GenerateCommand extends GeneratorCommand
{
    protected $signature = 'command-bus:make:command
                            {name : The name of the command}';

    protected $description = 'Generate a new command';

    protected string $successMessage = 'Command created successfully!';

    protected string $alreadyExistsMessage = 'Command already exists!';

    protected function directoryPath(): string
    {
        return app_path("Commands/{$this->argument('name')}");
    }

    protected function generateFiles(): void
    {
        $this->generateCommand();
        $this->generateHandler();
    }

    private function generateCommand(): void
    {
        $this->generateFile(
            'command',
            [
                'command' => $this->argument('name'),
            ],
            "{$this->directoryPath()}/{$this->argument('name')}.php"
        );
    }

    private function generateHandler(): void
    {
        $this->generateFile(
            'handler',
            [
                'command' => $this->argument('name'),
            ],
            "{$this->directoryPath()}/{$this->argument('name')}Handler.php"
        );
    }
}
