<?php

namespace App\Application\User\Commands\UpdateUser;

final class UpdateUserCommand
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $role = null,
    ) {}
}
