<?php

namespace App\GraphQL\Mutations\Page;

use App\Application\Page\Commands\DeletePage\DeletePageCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class DeletePageMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new DeletePageCommand(id: (int) $args['id']));
    }
}
