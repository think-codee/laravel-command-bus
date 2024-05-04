<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus\Tests\Fixtures\DispatcherMiddleware;

use ThinkCodee\Laravel\CommandBus\Attributes\Middleware;

#[Middleware([TestPrependMiddleware::class], true)]
#[Middleware([TestAppendMiddleware::class])]
class TestCommandHandlerWithMiddlewareAttribute
{
    public function handle(): void {}
}
