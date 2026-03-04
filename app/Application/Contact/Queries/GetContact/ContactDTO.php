<?php

namespace App\Application\Contact\Queries\GetContact;

use App\Domain\Contact\Entities\Contact;

class ContactDTO
{
    public function __construct(
        public readonly int     $id,
        public readonly string  $name,
        public readonly ?string $tel,
        public readonly string  $email,
        public readonly string  $type,
        public readonly string  $message,
        public readonly string  $status,
        public readonly string  $created_at,
        public readonly string  $updated_at,
    ) {}

    public static function fromEntity(Contact $contact): self
    {
        return new self(
            id:         $contact->id()->value(),
            name:       $contact->name(),
            tel:        $contact->tel(),
            email:      $contact->email(),
            type:       $contact->type(),
            message:    $contact->message(),
            status:     $contact->status()->value,
            created_at: $contact->createdAt()->format('Y-m-d H:i:s'),
            updated_at: $contact->updatedAt()->format('Y-m-d H:i:s'),
        );
    }
}
