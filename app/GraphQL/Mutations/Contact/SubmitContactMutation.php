<?php

namespace App\GraphQL\Mutations\Contact;

use App\Application\Contact\Commands\SubmitContact\SubmitContactCommand;
use App\Application\Shared\Bus\CommandBusInterface;

class SubmitContactMutation
{
    public function __construct(private readonly CommandBusInterface $commandBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->commandBus->dispatch(new SubmitContactCommand(
            name:    $args['name'],
            tel:     $args['tel']     ?? null,
            email:   $args['email'],
            type:    $args['type'],
            message: $args['message'],
        ));
    }
}
