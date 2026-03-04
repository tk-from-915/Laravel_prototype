<?php

namespace App\Application\User\Queries\GetUser;

use App\Domain\User\Entities\User;

final class UserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $role,
        public readonly string $created_at,
        public readonly ?string $updated_at,
    ) {}

    public static function fromEntity(User $user): self
    {
        return new self(
            id: $user->id()->value(),
            name: $user->name()->value(),
            email: $user->email()->value(),
            role: $user->role()->value,
            created_at: $user->createdAt()->format('Y-m-d H:i:s'),
            updated_at: $user->updatedAt()?->format('Y-m-d H:i:s'),
        );
    }
}
