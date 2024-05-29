<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus;

use Illuminate\Support\ServiceProvider;
use ThinkCodee\Laravel\CommandBus\Commands\GenerateBus;
use ThinkCodee\Laravel\CommandBus\Commands\GenerateCommand;

class CommandBusServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->bootConfig();
        $this->bootBuses();
        $this->bootCommands();
    }

    private function bootConfig(): void
    {
        $this->publishes([
            __DIR__.'/../config/command_bus.php' => config_path('command_bus.php'),
        ], 'command-bus-config');
    }

    private function bootBuses(): void
    {
        foreach (config('command_bus.buses') as $data) {
            $this->newBusRegistrar()
                ->register(BusData::fromArray($data));
        }
    }

    private function newBusRegistrar(): BusRegistrar
    {
        return new BusRegistrar($this->app);
    }

    private function bootCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
                GenerateBus::class
            ]);
        }
    }
}
