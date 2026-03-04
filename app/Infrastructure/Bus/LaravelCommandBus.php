<?php

namespace App\Infrastructure\Bus;

use App\Application\Shared\Bus\CommandBusInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\DB;

class LaravelCommandBus implements CommandBusInterface
{
    public function __construct(private readonly Container $container) {}

    public function dispatch(object $command): mixed
    {
        $handler = $this->container->make($this->resolveHandler($command));

        return DB::transaction(fn () => $handler->handle($command));
    }

    private function resolveHandler(object $command): string
    {
        // App\Application\Content\Commands\CreatePost\CreatePostCommand
        // → App\Application\Content\Commands\CreatePost\CreatePostHandler
        return str_replace('Command', 'Handler', get_class($command));
    }
}
