<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\Handler;

use ThinkCodee\Laravel\CommandBus\Attributes\Handler;
use ThinkCodee\Laravel\CommandBus\Contracts\Command;

#[Handler(TestCommandWithHandlerAndMethodAttributeHandler::class, 'customMethod')]
class TestCommandWithHandlerAndMethodAttribute implements Command
{
}