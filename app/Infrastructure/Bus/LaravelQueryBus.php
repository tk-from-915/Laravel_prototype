<?php

namespace App\Infrastructure\Bus;

use App\Application\Shared\Bus\QueryBusInterface;
use Illuminate\Contracts\Container\Container;

class LaravelQueryBus implements QueryBusInterface
{
    public function __construct(private readonly Container $container) {}

    public function dispatch(object $query): mixed
    {
        $handler = $this->container->make($this->resolveHandler($query));

        return $handler->handle($query);
    }

    private function resolveHandler(object $query): string
    {
        // App\Application\Content\Queries\GetPost\GetPostQuery
        // → App\Application\Content\Queries\GetPost\GetPostHandler
        $fqcn      = get_class($query);
        $namespace = substr($fqcn, 0, strrpos($fqcn, '\\'));
        $className = substr($fqcn, strrpos($fqcn, '\\') + 1);

        return $namespace . '\\' . str_replace('Query', 'Handler', $className);
    }
}
