<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures;

use ThinkCodee\Laravel\CommandBus\Attributes\Handler;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;

#[Handler('someInvalidHandler')]
class TestCommandWithInvalidHandlerAttribute implements Command
{

}
