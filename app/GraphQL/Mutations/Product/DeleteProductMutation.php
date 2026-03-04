<?php

namespace App\GraphQL\Mutations\Product;

use App\Application\Product\Commands\DeleteProduct\DeleteProductCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class DeleteProductMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new DeleteProductCommand(id: (int) $args['id']));
    }
}
