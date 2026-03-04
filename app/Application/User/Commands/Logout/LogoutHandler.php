<?php

namespace App\Application\User\Commands\Logout;

use App\Application\Shared\Auth\AuthServiceInterface;

class LogoutHandler
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
    ) {}

    public function handle(LogoutCommand $command): bool
    {
        $this->authService->revokeCurrentToken();

        return true;
    }
}
