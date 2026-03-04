<?php

namespace App\Application\Contact\Commands\DeleteContact;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\ValueObjects\ContactId;

class DeleteContactHandler
{
    public function __construct(private readonly ContactRepositoryInterface $contacts) {}

    public function handle(DeleteContactCommand $command): bool
    {
        $contact = $this->contacts->findById(new ContactId($command->id))
            ?? throw new \DomainException("Contact not found: {$command->id}");

        $this->contacts->delete($contact->id());

        return true;
    }
}
