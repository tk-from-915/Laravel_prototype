<?php

namespace App\Providers;

use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\Shared\Bus\QueryBusInterface;
use App\Infrastructure\Bus\LaravelCommandBus;
use App\Infrastructure\Bus\LaravelQueryBus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CommandBusInterface::class, LaravelCommandBus::class);
        $this->app->bind(QueryBusInterface::class, LaravelQueryBus::class);
    }

    public function boot(): void {}
}

