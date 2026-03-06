<?php

namespace App\Application\User\Commands\ForgotPassword;

final class ForgotPasswordCommand
{
    public function __construct(
        public readonly string $email,
    ) {}
}
