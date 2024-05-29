<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Commands;

use Illuminate\Support\Facades\File;
use ThinkCodee\Laravel\CommandBus\Tests\TestCase;

class GeneratorCommandTestCase extends TestCase
{
    protected function tearDown(): void
    {
        foreach ($this->getTeardownDirectories() as $directory) {
            File::deleteDirectory($directory);
        }

        parent::tearDown();
    }

    protected function getTeardownDirectories(): array
    {
        return [];
    }
}
