<?php

namespace App\GraphQL\Queries\Page;

use App\Application\Page\Queries\ListPages\ListPagesQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class ListPagesResolver
{
    public function __construct(private readonly QueryBusInterface $queryBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->queryBus->dispatch(new ListPagesQuery(
            page:    (int) ($args['page']    ?? 1),
            perPage: (int) ($args['perPage'] ?? 15),
            status:  $args['status']         ?? null,
        ));
    }
}
