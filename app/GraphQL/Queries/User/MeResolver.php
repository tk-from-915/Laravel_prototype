<?php

namespace App\GraphQL\Queries\User;

use App\Application\Shared\Bus\QueryBusInterface;
use App\Application\User\Queries\GetUser\GetUserQuery;
use App\Application\User\Queries\GetUser\UserDTO;

class MeResolver
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {}

    public function __invoke($_, array $args): ?UserDTO
    {
        $userId = auth()->id();

        if (!$userId) {
            return null;
        }

        return $this->queryBus->dispatch(new GetUserQuery((int) $userId));
    }
}
