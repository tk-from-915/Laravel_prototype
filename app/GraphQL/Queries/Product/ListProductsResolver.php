<?php

namespace App\GraphQL\Queries\Product;

use App\Application\Product\Queries\ListProducts\ListProductsQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class ListProductsResolver
{
    public function __construct(private readonly QueryBusInterface $queryBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->queryBus->dispatch(new ListProductsQuery(
            page:       (int) ($args['page']       ?? 1),
            perPage:    (int) ($args['perPage']     ?? 15),
            status:     $args['status']             ?? null,
            categoryId: isset($args['categoryId']) ? (int) $args['categoryId'] : null,
        ));
    }
}
