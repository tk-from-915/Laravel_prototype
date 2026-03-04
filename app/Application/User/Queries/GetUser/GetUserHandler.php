<?php

namespace App\Application\User\Queries\GetUser;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\ValueObjects\UserId;

class GetUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function handle(GetUserQuery $query): ?UserDTO
    {
        $user = $this->userRepository->findById(new UserId($query->id));

        return $user !== null ? UserDTO::fromEntity($user) : null;
    }
}
