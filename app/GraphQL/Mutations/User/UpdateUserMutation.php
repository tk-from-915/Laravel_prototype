<?php

namespace App\GraphQL\Mutations\User;

use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\User\Commands\UpdateUser\UpdateUserCommand;
use App\Application\User\Queries\GetUser\UserDTO;

class UpdateUserMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): UserDTO
    {
        return $this->commandBus->dispatch(new UpdateUserCommand(
            id: (int) $args['id'],
            name: $args['name'] ?? null,
            email: $args['email'] ?? null,
            role: $args['role'] ?? null,
        ));
    }
}
