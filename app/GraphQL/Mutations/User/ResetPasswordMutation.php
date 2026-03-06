<?php

namespace App\GraphQL\Mutations\User;

use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\User\Commands\ResetPassword\ResetPasswordCommand;

class ResetPasswordMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): bool
    {
        return $this->commandBus->dispatch(new ResetPasswordCommand(
            email: $args['email'],
            token: $args['token'],
            password: $args['password'],
        ));
    }
}
