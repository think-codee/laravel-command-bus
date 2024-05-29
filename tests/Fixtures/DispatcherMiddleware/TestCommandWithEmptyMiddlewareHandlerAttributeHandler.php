<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware;

use ThinkCodee\Laravel\CommandBus\Attributes\ResetMiddleware;

#[ResetMiddleware]
class TestCommandWithEmptyMiddlewareHandlerAttributeHandler
{
    public function handle(): void {}
}
