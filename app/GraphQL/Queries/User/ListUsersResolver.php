<?php

namespace App\GraphQL\Queries\User;

use App\Application\Shared\Bus\QueryBusInterface;
use App\Application\User\Queries\ListUsers\ListUsersQuery;

class ListUsersResolver
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {}

    public function __invoke($_, array $args): array
    {
        return $this->queryBus->dispatch(new ListUsersQuery(
            page: (int) ($args['page'] ?? 1),
            perPage: (int) ($args['perPage'] ?? 15),
        ));
    }
}
