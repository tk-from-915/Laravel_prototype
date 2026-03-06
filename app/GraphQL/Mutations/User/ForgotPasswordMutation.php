<?php

namespace App\GraphQL\Mutations\User;

use App\Application\Shared\Bus\CommandBusInterface;
use App\Application\User\Commands\ForgotPassword\ForgotPasswordCommand;

class ForgotPasswordMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): bool
    {
        return $this->commandBus->dispatch(new ForgotPasswordCommand(
            email: $args['email'],
        ));
    }
}
