<?php

namespace App\Application\User\Commands\RegisterUser;

use App\Application\Shared\Auth\AuthServiceInterface;
use App\Application\User\Commands\Login\AuthPayload;
use App\Application\User\Queries\GetUser\UserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;

class RegisterUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AuthServiceInterface $authService,
    ) {}

    public function handle(RegisterUserCommand $command): AuthPayload
    {
        $email = new Email($command->email);

        if ($this->userRepository->findByEmail($email) !== null) {
            throw new \DomainException("Email {$command->email} is already in use.");
        }

        $user = $this->userRepository->create(
            name: new UserName($command->name),
            email: $email,
            plainPassword: $command->password,
            role: UserRole::from($command->role),
        );

        return new AuthPayload(
            token: $this->authService->createToken($user->id()),
            user: UserDTO::fromEntity($user),
        );
    }
}
