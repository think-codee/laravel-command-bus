<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware;

use ThinkCodee\Laravel\CommandBus\Contracts\Command;

class TestCommandWithEmptyMiddlewareHandlerAttribute implements Command
{
}
