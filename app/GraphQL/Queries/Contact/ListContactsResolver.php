<?php

namespace App\GraphQL\Queries\Contact;

use App\Application\Contact\Queries\ListContacts\ListContactsQuery;
use App\Application\Shared\Bus\QueryBusInterface;

class ListContactsResolver
{
    public function __construct(private readonly QueryBusInterface $queryBus) {}

    public function __invoke(mixed $root, array $args): mixed
    {
        return $this->queryBus->dispatch(new ListContactsQuery(
            page:    (int) ($args['page']    ?? 1),
            perPage: (int) ($args['perPage'] ?? 15),
            status:  $args['status']         ?? null,
        ));
    }
}
