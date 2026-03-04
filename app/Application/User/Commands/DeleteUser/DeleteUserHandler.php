<?php

namespace App\Application\User\Commands\DeleteUser;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;

class DeleteUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function handle(DeleteUserCommand $command): bool
    {
        $userId = new UserId($command->id);

        if ($this->userRepository->findById($userId) === null) {
            throw new \DomainException("User {$command->id} not found.");
        }

        $this->userRepository->delete($userId);

        return true;
    }
}
