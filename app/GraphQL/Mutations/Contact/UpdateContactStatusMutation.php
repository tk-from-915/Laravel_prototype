<?php

namespace App\GraphQL\Mutations\Contact;

use App\Application\Contact\Commands\UpdateContactStatus\UpdateContactStatusCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class UpdateContactStatusMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new UpdateContactStatusCommand(
            id:     (int) $args['id'],
            status: $args['status'],
        ));
    }
}
