<?php

namespace App\Application\User\Queries\ListUsers;

final class ListUsersQuery
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $perPage = 15,
    ) {}
}
