<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherHandler;

use ThinkCodee\Laravel\CommandBus\Attributes\Handler;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;

#[Handler(TestCommandWithHandlerAttributeHandler::class)]
class TestCommandWithHandlerAttribute implements Command
{
}
