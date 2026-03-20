<?php

namespace App\GraphQL\Mutations\Product;

use App\Application\Product\Commands\CreateComment\CreateCommentCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class CreateCommentMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new CreateCommentCommand(
            productId: (int) $args['productId'],
            name:      $args['name'],
            body:      $args['body'],
        ));
    }
}
