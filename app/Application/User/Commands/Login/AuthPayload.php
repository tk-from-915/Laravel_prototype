<?php

namespace App\Application\User\Commands\Login;

use App\Application\User\Queries\GetUser\UserDTO;

final class AuthPayload
{
    public function __construct(
        public readonly string $token,
        public readonly UserDTO $user,
    ) {}
}
