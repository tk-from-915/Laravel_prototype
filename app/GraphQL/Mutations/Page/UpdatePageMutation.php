<?php

namespace App\GraphQL\Mutations\Page;

use App\Application\Page\Commands\UpdatePage\UpdatePageCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class UpdatePageMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new UpdatePageCommand(
            id:      (int) $args['id'],
            title:   $args['title']   ?? null,
            body:    $args['body']    ?? null,
            publish: $args['publish'] ?? null,
        ));
    }
}
