<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Commands;

class GenerateBus extends GeneratorCommand
{
    protected $signature = 'command-bus:make:bus
                            {name : The name of the bus}';

    protected $description = 'Create a bus';

    protected string $successMessage = 'Bus created successfully!';

    protected string $alreadyExistsMessage = 'Bus already exists!';

    protected function directoryPath(): string
    {
        return app_path("Buses/{$this->argument('name')}");
    }

    protected function generateFiles(): void
    {
        $this->generateBus();
        $this->generateInterface();
    }

    private function generateBus(): void
    {
        $this->generateFile(
            'bus',
            [
                'bus' => $this->argument('name')
            ],
            "{$this->directoryPath()}/{$this->argument('name')}Bus.php"
        );
    }

    private function generateInterface(): void
    {
        $this->generateFile(
            'interface',
            [
                'bus' => $this->argument('name')
            ],
            "{$this->directoryPath()}/{$this->argument('name')}Interface.php"
        );
    }
}
