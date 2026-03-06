<?php

namespace App\GraphQL\Mutations\Contact;

use App\Application\Contact\Commands\ReplyContact\ReplyContactCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class ReplyContactMutation
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {}

    public function __invoke($_, array $args): bool
    {
        return $this->commandBus->dispatch(new ReplyContactCommand(
            id:      (int) $args['id'],
            subject: $args['subject'],
            message: $args['message'],
        ));
    }
}
