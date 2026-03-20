<?php

namespace App\GraphQL\Queries\Product;

use App\Application\Product\Queries\ListAllComments\ListAllCommentsQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class ListAllCommentsResolver
{
    public function __construct(private readonly QueryBusInterface $queryBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->queryBus->dispatch(new ListAllCommentsQuery(
            status: $args['status'] ?? null,
        ));
    }
}
