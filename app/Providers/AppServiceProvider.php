<?php

namespace App\Providers;

use App\Application\Shared\Auth\AuthServiceInterface;
use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\Shared\Bus\QueryBusInterface;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\Auth\SanctumAuthService;
use App\Infrastructure\Bus\LaravelCommandBus;
use App\Infrastructure\Bus\LaravelQueryBus;
use App\Infrastructure\Persistence\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bus
        $this->app->bind(CommandBusInterface::class, LaravelCommandBus::class);
        $this->app->bind(QueryBusInterface::class, LaravelQueryBus::class);

        // Auth
        $this->app->bind(AuthServiceInterface::class, SanctumAuthService::class);

        // Repositories
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    public function boot(): void {}
}
