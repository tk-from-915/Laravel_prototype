<?php

namespace App\GraphQL\Mutations\Content;

use App\Application\Content\Commands\CreatePost\CreatePostCommand;
use App\Application\Content\Queries\GetPost\PostDTO;
use App\Application\Shared\Bus\CommandBusInterface;

class CreatePostMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): PostDTO
    {
        return $this->commandBus->dispatch(new CreatePostCommand(
            type: $args['type'],
            title: $args['title'],
            body: $args['body'],
            authorId: (int) auth()->id(),
            status: $args['status'] ?? 'draft',
        ));
    }
}
