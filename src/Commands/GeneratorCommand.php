<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

abstract class GeneratorCommand extends Command
{
    use HasStubs;

    protected string $alreadyExistsMessage = '';

    protected string $successMessage = '';

    public function handle(): int
    {
        if (File::exists($this->directoryPath())) {
            $this->error($this->alreadyExistsMessage);

            return Command::FAILURE;
        }

        $this->makeDirectory();

        $this->generateFiles();

        $this->info($this->successMessage);

        return Command::SUCCESS;
    }

    protected abstract function directoryPath(): string;

    protected abstract function generateFiles(): void;

    protected function generateFile(string $stub, array $replacements, string $path): void
    {
        $stub = $this->getStub($stub, $replacements);

        File::put($path, $stub);
    }

    private function makeDirectory(): void
    {
        File::makeDirectory($this->directoryPath(), 0777, true);
    }
}
