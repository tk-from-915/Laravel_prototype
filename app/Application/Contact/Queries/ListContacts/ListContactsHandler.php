<?php

namespace App\Application\Contact\Queries\ListContacts;

use App\Application\Contact\Queries\GetContact\ContactDTO;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;

class ListContactsHandler
{
    public function __construct(private readonly ContactRepositoryInterface $contacts) {}

    public function handle(ListContactsQuery $query): array
    {
        $items = $this->contacts->findAll(
            page:    $query->page,
            perPage: $query->perPage,
            status:  $query->status,
        );

        $total = $this->contacts->countAll($query->status);

        return [
            'data'         => array_map(fn ($c) => ContactDTO::fromEntity($c), $items),
            'total'        => $total,
            'per_page'     => $query->perPage,
            'current_page' => $query->page,
        ];
    }
}
