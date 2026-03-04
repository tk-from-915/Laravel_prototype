<?php

namespace App\GraphQL\Mutations\Content;

use App\Application\Content\Commands\UpdatePost\UpdatePostCommand;
use App\Application\Content\Queries\GetPost\PostDTO;
use App\Application\Shared\Bus\CommandBusInterface;

class UpdatePostMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): PostDTO
    {
        return $this->commandBus->dispatch(new UpdatePostCommand(
            id: (int) $args['id'],
            title: $args['title'] ?? null,
            body: $args['body'] ?? null,
        ));
    }
}
