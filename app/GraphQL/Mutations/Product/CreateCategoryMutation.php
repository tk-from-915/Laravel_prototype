<?php

namespace App\GraphQL\Mutations\Product;

use App\Application\Product\Commands\CreateCategory\CreateCategoryCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class CreateCategoryMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new CreateCategoryCommand(
            slug: $args['slug'],
            name: $args['name'],
        ));
    }
}
