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
        $this->bootBuses();

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
                GenerateBus::class
            ]);
        }
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
}
