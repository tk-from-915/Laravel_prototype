<?php

namespace App\GraphQL\Queries\Product;

use App\Application\Product\Queries\GetProduct\GetProductQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class GetProductResolver
{
    public function __construct(private readonly QueryBusInterface $queryBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->queryBus->dispatch(new GetProductQuery(id: (int) $args['id']));
    }
}
