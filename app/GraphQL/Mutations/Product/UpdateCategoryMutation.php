<?php

namespace App\GraphQL\Mutations\Product;

use App\Application\Product\Commands\UpdateCategory\UpdateCategoryCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class UpdateCategoryMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new UpdateCategoryCommand(
            id:   (int) $args['id'],
            slug: $args['slug'],
            name: $args['name'],
        ));
    }
}
