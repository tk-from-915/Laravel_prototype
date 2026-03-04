<?php

namespace App\Domain\Contact\Repositories;

use App\Domain\Contact\Entities\Contact;
use App\Domain\Contact\ValueObjects\ContactId;

interface ContactRepositoryInterface
{
    public function findById(ContactId $id): ?Contact;

    public function create(
        string  $name,
        ?string $tel,
        string  $email,
        string  $type,
        string  $message,
    ): Contact;

    public function update(Contact $contact): Contact;

    public function delete(ContactId $id): void;

    /** @return Contact[] */
    public function findAll(int $page, int $perPage, ?string $status = null): array;

    public function countAll(?string $status = null): int;
}
