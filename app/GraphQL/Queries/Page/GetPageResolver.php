<?php

namespace App\GraphQL\Queries\Page;

use App\Application\Page\Queries\GetPage\GetPageQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class GetPageResolver
{
    public function __construct(private readonly QueryBusInterface $queryBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->queryBus->dispatch(new GetPageQuery(
            id:   isset($args['id'])   ? (int) $args['id'] : null,
            slug: $args['slug']        ?? null,
        ));
    }
}
