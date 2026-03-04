<?php

namespace App\GraphQL\Mutations\Product;

use App\Application\Product\Commands\UpdateProduct\UpdateProductCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class UpdateProductMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new UpdateProductCommand(
            id:          (int) $args['id'],
            name:        $args['name']        ?? null,
            description: $args['description'] ?? null,
            price:       isset($args['price']) ? (int) $args['price'] : null,
            status:      $args['status']      ?? null,
            categoryIds: $args['categoryIds'] ?? null,
        ));
    }
}
