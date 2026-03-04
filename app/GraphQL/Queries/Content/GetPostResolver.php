<?php

namespace App\GraphQL\Queries\Content;

use App\Application\Content\Queries\GetPost\GetPostQuery;
use App\Application\Content\Queries\GetPost\PostDTO;
use App\Application\Shared\Bus\QueryBusInterface;

class GetPostResolver
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {}

    public function __invoke($_, array $args): ?PostDTO
    {
        return $this->queryBus->dispatch(new GetPostQuery((int) $args['id']));
    }
}
