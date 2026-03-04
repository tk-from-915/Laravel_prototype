<?php

namespace App\Application\Contact\Queries\ListContacts;

class ListContactsQuery
{
    public function __construct(
        public readonly int     $page    = 1,
        public readonly int     $perPage = 15,
        public readonly ?string $status  = null,
    ) {}
}
