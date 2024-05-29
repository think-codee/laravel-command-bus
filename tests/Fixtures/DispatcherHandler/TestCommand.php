<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherHandler;

use ThinkCodee\Laravel\CommandBus\Contracts\Command;

class TestCommand implements Command
{
    public function __construct() {}
}
