<?php

namespace App\Application\Page\Queries\ListPages;

class ListPagesQuery
{
    public function __construct(
        public readonly int     $page    = 1,
        public readonly int     $perPage = 15,
        public readonly ?string $status  = null,
    ) {}
}
