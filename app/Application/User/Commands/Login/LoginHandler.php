<?php

namespace App\Application\User\Commands\Login;

use App\Application\Shared\Auth\AuthServiceInterface;
use App\Application\User\Queries\GetUser\UserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;

class LoginHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AuthServiceInterface $authService,
    ) {}

    public function handle(LoginCommand $command): AuthPayload
    {
        $user = $this->userRepository->verifyCredentials(
            email: new Email($command->email),
            plainPassword: $command->password,
        );

        if ($user === null) {
            throw new \DomainException('The provided credentials are incorrect.');
        }

        return new AuthPayload(
            token: $this->authService->createToken($user->id()),
            user: UserDTO::fromEntity($user),
        );
    }
}
