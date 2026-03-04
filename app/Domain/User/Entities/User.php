<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;

class User
{
    private function __construct(
        private readonly UserId $id,
        private UserName $name,
        private Email $email,
        private UserRole $role,
        private readonly \DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {}

    /** DBから再構成するときに使うファクトリ */
    public static function reconstitute(
        UserId $id,
        UserName $name,
        Email $email,
        UserRole $role,
        \DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt = null,
    ): self {
        return new self($id, $name, $email, $role, $createdAt, $updatedAt);
    }

    // --- Getters ---

    public function id(): UserId { return $this->id; }
    public function name(): UserName { return $this->name; }
    public function email(): Email { return $this->email; }
    public function role(): UserRole { return $this->role; }
    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    public function updatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }

    // --- Behaviors ---

    public function rename(UserName $name): void
    {
        $this->name = $name;
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function changeRole(UserRole $role): void
    {
        $this->role = $role;
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }
}
