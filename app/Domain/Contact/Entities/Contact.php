<?php

namespace App\Domain\Contact\Entities;

use App\Domain\Contact\ValueObjects\ContactId;
use App\Domain\Contact\ValueObjects\ContactStatus;

class Contact
{
    private function __construct(
        private readonly ContactId          $id,
        private readonly string             $name,
        private readonly ?string            $tel,
        private readonly string             $email,
        private readonly string             $type,
        private readonly string             $message,
        private ContactStatus               $status,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
    ) {}

    public static function reconstitute(
        int     $id,
        string  $name,
        ?string $tel,
        string  $email,
        string  $type,
        string  $message,
        string  $status,
        string  $createdAt,
        string  $updatedAt,
    ): self {
        return new self(
            new ContactId($id),
            $name,
            $tel,
            $email,
            $type,
            $message,
            ContactStatus::from($status),
            new \DateTimeImmutable($createdAt),
            new \DateTimeImmutable($updatedAt),
        );
    }

    public function markAsRead(): void
    {
        $this->status    = ContactStatus::Read;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function markAsReplied(): void
    {
        $this->status    = ContactStatus::Replied;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function updateStatus(ContactStatus $status): void
    {
        $this->status    = $status;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function id(): ContactId                { return $this->id; }
    public function name(): string                 { return $this->name; }
    public function tel(): ?string                 { return $this->tel; }
    public function email(): string                { return $this->email; }
    public function type(): string                 { return $this->type; }
    public function message(): string              { return $this->message; }
    public function status(): ContactStatus        { return $this->status; }
    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }
}
