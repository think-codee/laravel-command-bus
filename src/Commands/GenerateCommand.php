<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateCommand extends Command
{
    use HasStubs;

    protected $signature = "command-bus:make:command
                            {name : The name of the command}";

    protected $description = "Generate a new command";

    public function handle(): int
    {
        if (File::exists($this->directoryPath())) {
            $this->error("Command already exists!");

            return Command::FAILURE;
        }

        $this->makeDirectory();
        $this->generateCommand();
        $this->generateHandler();

        $this->info('Command created successfully!');

        return Command::SUCCESS;
    }

    private function generateCommand(): void
    {
        $stub = $this->getStub('command', ['command' => $this->argument('name')]);

        File::put("{$this->directoryPath()}/{$this->argument('name')}.php", $stub);
    }

    private function generateHandler(): void
    {
        $stub = $this->getStub('handler', ['command' => $this->argument('name')]);

        File::put("{$this->directoryPath()}/{$this->argument('name')}Handler.php", $stub);
    }

    private function makeDirectory(): void
    {
        File::makeDirectory($this->directoryPath(), 0777, true);
    }

    private function directoryPath(): string
    {
        return app_path("Commands/{$this->argument('name')}");
    }
}
