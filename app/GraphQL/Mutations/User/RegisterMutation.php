<?php

namespace App\GraphQL\Mutations\User;

use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\User\Commands\RegisterUser\RegisterUserCommand;
use App\Application\User\Commands\Login\AuthPayload;

class RegisterMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): AuthPayload
    {
        return $this->commandBus->dispatch(new RegisterUserCommand(
            name: $args['name'],
            email: $args['email'],
            password: $args['password'],
        ));
    }
}
