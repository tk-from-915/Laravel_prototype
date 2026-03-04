<?php

namespace App\GraphQL\Queries\Content;

use App\Application\Content\Queries\ListPosts\ListPostsQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class ListPostsResolver
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {}

    public function __invoke($_, array $args): array
    {
        return $this->queryBus->dispatch(new ListPostsQuery(
            page: (int) ($args['page'] ?? 1),
            perPage: (int) ($args['perPage'] ?? 15),
            type: $args['type'] ?? null,
            status: $args['status'] ?? null,
        ));
    }
}
