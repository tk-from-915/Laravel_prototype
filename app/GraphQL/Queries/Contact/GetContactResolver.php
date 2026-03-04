<?php

namespace App\GraphQL\Queries\Contact;

use App\Application\Contact\Queries\GetContact\GetContactQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class GetContactResolver
{
    public function __construct(private readonly QueryBusInterface $queryBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->queryBus->dispatch(new GetContactQuery(id: (int) $args['id']));
    }
}
