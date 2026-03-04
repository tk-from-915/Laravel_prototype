<?php

namespace App\GraphQL\Mutations\User;

use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\User\Commands\Login\AuthPayload;
use App\Application\User\Commands\Login\LoginCommand;

class LoginMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): AuthPayload
    {
        return $this->commandBus->dispatch(new LoginCommand(
            email: $args['email'],
            password: $args['password'],
        ));
    }
}
