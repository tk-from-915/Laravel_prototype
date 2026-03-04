<?php

namespace App\Application\Contact\Commands\UpdateContactStatus;

use App\Application\Contact\Queries\GetContact\ContactDTO;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\ValueObjects\ContactId;
use App\Domain\Contact\ValueObjects\ContactStatus;

class UpdateContactStatusHandler
{
    public function __construct(private readonly ContactRepositoryInterface $contacts) {}

    public function handle(UpdateContactStatusCommand $command): ContactDTO
    {
        $contact = $this->contacts->findById(new ContactId($command->id))
            ?? throw new \DomainException("Contact not found: {$command->id}");

        $contact->updateStatus(ContactStatus::from($command->status));

        $saved = $this->contacts->update($contact);

        return ContactDTO::fromEntity($saved);
    }
}
