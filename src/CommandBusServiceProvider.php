<?php

declare(strict_types=1);

namespace ThinkCodee\Laravel\CommandBus;

use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
//        $this->registerBuses();
    }

    public function boot(): void
    {
        $this->bootBuses();
    }

    private function bootBuses(): void
    {
        foreach (config('command_bus.buses') as $name => $data) {
            $this->newBusRegistrar()
                ->register($data);
        }
    }

    private function newBusRegistrar(): BusRegistrar
    {
        return new BusRegistrar();
    }
}
