<?php

namespace App\GraphQL\Mutations\Content;

use App\Application\Content\Commands\DeletePost\DeletePostCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class DeletePostMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): bool
    {
        return $this->commandBus->dispatch(new DeletePostCommand(
            id: (int) $args['id'],
        ));
    }
}
