<?php

namespace App\Application\Contact\Queries\GetContact;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\ValueObjects\ContactId;

class GetContactHandler
{
    public function __construct(private readonly ContactRepositoryInterface $contacts) {}

    public function handle(GetContactQuery $query): ?ContactDTO
    {
        $contact = $this->contacts->findById(new ContactId($query->id));

        return $contact ? ContactDTO::fromEntity($contact) : null;
    }
}
