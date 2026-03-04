<?php

namespace App\Application\User\Commands\Login;

final class LoginCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
