<?php

namespace App\GraphQL\Mutations\Product;

use App\Application\Product\Commands\CreateProduct\CreateProductCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class CreateProductMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new CreateProductCommand(
            name:        $args['name'],
            description: $args['description'] ?? null,
            price:       $args['price'],
            status:      $args['status'] ?? 'active',
            authorId:    auth()->id(),
            categoryIds: $args['categoryIds'] ?? [],
        ));
    }
}
