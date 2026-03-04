<?php

namespace App\Application\User\Queries\ListUsers;

use App\Application\User\Queries\GetUser\UserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;

class ListUsersHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    /**
     * @return array{ data: UserDTO[], total: int, per_page: int, current_page: int }
     */
    public function handle(ListUsersQuery $query): array
    {
        $users = $this->userRepository->findAll($query->page, $query->perPage);

        return [
            'data'         => array_map(fn ($u) => UserDTO::fromEntity($u), $users),
            'total'        => $this->userRepository->countAll(),
            'per_page'     => $query->perPage,
            'current_page' => $query->page,
        ];
    }
}
