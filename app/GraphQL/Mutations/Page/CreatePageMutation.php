<?php

namespace App\GraphQL\Mutations\Page;

use App\Application\Page\Commands\CreatePage\CreatePageCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class CreatePageMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new CreatePageCommand(
            slug:     $args['slug'],
            title:    $args['title'],
            body:     $args['body'],
            status:   $args['status'] ?? 'draft',
            authorId: auth()->id(),
        ));
    }
}
