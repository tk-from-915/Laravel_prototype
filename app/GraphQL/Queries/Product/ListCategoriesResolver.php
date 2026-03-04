<?php

namespace App\GraphQL\Queries\Product;

use App\Application\Product\Queries\ListCategories\ListCategoriesQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class ListCategoriesResolver
{
    public function __construct(private readonly QueryBusInterface $queryBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->queryBus->dispatch(new ListCategoriesQuery());
    }
}
