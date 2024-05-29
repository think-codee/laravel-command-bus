
# Laravel Command Bus

> This package provides a simple and efficient way to implement the command pattern in your Laravel applications, allowing for better separation of concerns and more maintainable code.

## Installation

Install with composer:

```bash
  composer require think-codee/laravel-command-bus
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="command-bus-config"
```

Below is the configuration file content:

```php
return [
    'buses' => [
        'default' => [
            'class' => \ThinkCodee\Laravel\CommandBus\Default\Bus::class,
            'interface' => \ThinkCodee\Laravel\CommandBus\Contracts\Bus::class,
            'alias' => 'bus.default',
            'middleware' => [],
            'handler_resolver' => \ThinkCodee\Laravel\CommandBus\Resolvers\SuffixHandlerResolver::class,
            'handler_method' => 'handle',
        ],
    ]
];
```
## Usage

This package allows you to create and manage multiple command buses, providing a robust and flexible system for handling different types of commands within your Laravel application. It is especially useful when implementing architectural patterns like CQRS (Command and Query Responsibility Segregation), which separates read and update operations. Each bus can be configured with its own set of middlewares and handler resolvers, enhancing the modularity and organization of your application.

### Defining buses

To create a bus, start by defining an interface:

```php
use ThinkCodee\Laravel\CommandBus\Contracts\CommandBus;

interface QueryBusInterface extends CommandBus
{
}
```

Next, create a class that implements this interface:

```php
use ThinkCodee\Laravel\CommandBus\Bus;

class QueryBus extends Bus implements QueryBusInterface
{
}
```

You may use the following artisan command to create a bus:

```bash
php artisan command-bus:make:bus QueryBus
```

Each bus must be registered in the configuration file. The package will bind the interface to the corresponding class and assign it an alias:

```php
'query' => [
    'class' => \App\Buses\Query\QueryBus::class,
    'interface' => \App\Buses\Query\QueryBusInterface::class,
    'alias' => 'bus.query',
];
```

You can then use the bus in your application as follows:

```php
use App\Buses\Query\QueryBusinterface; 

class Controller
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {}

    public function show(int $id)
    {
        $users = $this->queryBus->handle(
            new GetUserQuery($id)
        );

        // Alternatively:
        // app('bus.query')->handle(
        //     new GetUsersQuery()  
        // );
    }
}
```

### Defining commands and handlers

To define a command:

```php
use ThinkCodee\Laravel\CommandBus\Contracts\Command;

class GetUserQuery implements Command
{
    public function __construct(public int $id) {}
}
```

To define a handler for the command:

```php
class GetUserQueryHandler
{
    public function handle(GetUserQuery $query)
    {
        // Handle the command, e.g., process $query->id
        // return User::findOrFail($query->id);
    }
}
```

You may use the following artisan command to create a command with handler:

```bash
php artisan command-bus:make:command GetUserQuery
```

### Defining middleware

In this package, middleware works similarly to standard Laravel middlewares. They allow you to run code before or after a command is handled, providing a way to add common behavior to your command handling logic.

To define a middleware, create a class that processes the command before and after it is handled:

```php
class ExampleMiddleware
{
    public function handle(Command $command, Closure $next)
    {
        // Code to run before the command is handled
        // ...

        $response = $next($command);

        // Code to run after the command is handled
        // ...

        return $response;
    }
}
```

### Registering middleware

You can register middleware to specific command handlers using attributes:

* use the `#[Middleware]` attribute to add middleware to a handler.
* the second parameter of the attribute is true to prepend the middleware or false (or omitted) to append it.
* use the `#[ResetMiddleware]` attribute to remove all existing middleware for that command (registered in config) and apply only the specified middleware.

```php
#[Middleware([ExampleMiddleware::class], true)]
class TestCommandHandler
{
    public function handle(TestCommand $command): int
    {
        // This will prepend ExampleMiddlware to the existing middleware
    }
}
```

```php
#[ResetMiddleware]
#[Middleware([ExampleMiddleware::class])]
class AnotherCommandHandler
{
    public function handle(AnotherCommand $command): int
    {
        // Handle the command with ExampleMiddleware only
    }
}
```

You can still register middlewares in the configuration file, assigning them to specific buses:

```php
'query' => [
    'class' => \App\Buses\Query\QueryBus::class,
    'interface' => \App\Buses\Query\QueryBusInterface::class,
    'alias' => 'bus.query',
    'middleware' => [
        \App\Buses\Query\ExampleMiddleware::class
    ]
];
```

### Handler resolvers

Each bus has a handler resolver that determines how to resolve the appropriate handler for a given command. The resolver and the method used to handle the command are specified in the configuration file for each bus:

```php
'handler_resolver' => \ThinkCodee\Laravel\CommandBus\Resolvers\SuffixHandlerResolver::class,
'handler_method' => 'handle',
```

Every handler resolver must implement the `HandlerResolver` interface. The `SuffixHandlerResolver` comes by default with the package. If you have a command named `TestCommand.php`, it will try to resolve the handler name as `TestCommandHandler.php` in the same directory.

When a command is run through the resolved handler, it will try to use the method specified in the configuration file.

### Specifying a Handler for a Specific Command

You can also set a specific handler for a command using the `#[Handler]` attribute. The second parameter is optional and specifies the method name to be used. If not specified, the method name from the configuration file will be used.

```php
#[Handler(StoreUserCustomHandler::class, 'customMethod')]
class StoreUserCommand
{
    // Command implementation
}
```
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Running Tests

To run tests, run the following command

```bash
  composer test
```

