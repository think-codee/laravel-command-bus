<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler;

class TestCommandHandler
{
    public function handle(TestCommand $command): void {}
}
