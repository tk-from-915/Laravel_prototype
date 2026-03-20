<?php

namespace App\GraphQL\Mutations\Product;

use App\Application\Product\Commands\DeleteComment\DeleteCommentCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class DeleteCommentMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new DeleteCommentCommand(id: (int) $args['id']));
    }
}
