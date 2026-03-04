<?php

namespace App\GraphQL\Mutations\Content;

use App\Application\Content\Commands\PublishPost\PublishPostCommand;
use App\Application\Content\Queries\GetPost\PostDTO;
use App\Application\Shared\Bus\CommandBusInterface;

class PublishPostMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): PostDTO
    {
        return $this->commandBus->dispatch(new PublishPostCommand(
            id: (int) $args['id'],
            publish: $args['publish'] ?? true,
        ));
    }
}
