<?php

namespace App\Application\User\Commands\UpdateUser;

use App\Application\User\Queries\GetUser\UserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\ValueObjects\UserName;
use App\Domain\User\ValueObjects\UserRole;

class UpdateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function handle(UpdateUserCommand $command): UserDTO
    {
        $userId = new UserId($command->id);
        $user   = $this->userRepository->findById($userId);

        if ($user === null) {
            throw new \DomainException("User {$command->id} not found.");
        }

        if ($command->name !== null) {
            $user->rename(new UserName($command->name));
        }

        if ($command->email !== null) {
            $newEmail  = new Email($command->email);
            $duplicate = $this->userRepository->findByEmail($newEmail);
            if ($duplicate !== null && !$duplicate->id()->equals($userId)) {
                throw new \DomainException("Email {$command->email} is already in use.");
            }
            $user->changeEmail($newEmail);
        }

        if ($command->role !== null) {
            $user->changeRole(UserRole::from($command->role));
        }

        $this->userRepository->update($user);

        return UserDTO::fromEntity($user);
    }
}
