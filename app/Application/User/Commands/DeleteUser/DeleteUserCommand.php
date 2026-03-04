<?php

namespace App\Application\User\Commands\DeleteUser;

final class DeleteUserCommand
{
    public function __construct(
        public readonly int $id,
    ) {}
}
