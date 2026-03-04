<?php

namespace App\GraphQL\Mutations\Contact;

use App\Application\Contact\Commands\DeleteContact\DeleteContactCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class DeleteContactMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new DeleteContactCommand(id: (int) $args['id']));
    }
}
