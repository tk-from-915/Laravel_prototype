<?php

namespace App\GraphQL\Queries\Product;

use App\Application\Product\Queries\ListComments\ListCommentsQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class ListCommentsResolver
{
    public function __construct(private readonly QueryBusInterface $queryBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->queryBus->dispatch(new ListCommentsQuery(
            productId: (int) $args['productId'],
            status:    $args['status'] ?? null,
        ));
    }
}
