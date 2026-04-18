<?php

namespace App\GraphQL\Mutations\Product;

use App\Application\Product\Commands\DeleteCategory\DeleteCategoryCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class DeleteCategoryMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new DeleteCategoryCommand(
            id: (int) $args['id'],
        ));
    }
}
