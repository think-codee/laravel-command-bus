<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Commands;

use Illuminate\Support\Facades\File;

trait HasStubs
{
    private const BASE_PATH = __DIR__ . '/../../stubs';

    private function getStub(string $name, array $replacements = []): string
    {
        $stub = File::get($this->stubPath($name));

        foreach ($replacements as $search => $replace) {
            $stub = str_replace("{{ $search }}", $replace, $stub);
        }

        return $stub;
    }

    private function stubPath(string $name): string
    {
        return self::BASE_PATH . "/$name.stub";
    }
}
