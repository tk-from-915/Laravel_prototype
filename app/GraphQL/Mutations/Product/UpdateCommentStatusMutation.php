<?php

namespace App\GraphQL\Mutations\Product;

use App\Application\Product\Commands\UpdateCommentStatus\UpdateCommentStatusCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class UpdateCommentStatusMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new UpdateCommentStatusCommand(
            id:     (int) $args['id'],
            status: $args['status'],
        ));
    }
}
