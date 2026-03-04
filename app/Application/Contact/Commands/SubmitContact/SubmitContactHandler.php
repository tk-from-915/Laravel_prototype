<?php

namespace App\Application\Contact\Commands\SubmitContact;

use App\Application\Contact\Queries\GetContact\ContactDTO;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;

class SubmitContactHandler
{
    public function __construct(private readonly ContactRepositoryInterface $contacts) {}

    public function handle(SubmitContactCommand $command): ContactDTO
    {
        $contact = $this->contacts->create(
            name:    $command->name,
            tel:     $command->tel,
            email:   $command->email,
            type:    $command->type,
            message: $command->message,
        );

        return ContactDTO::fromEntity($contact);
    }
}
