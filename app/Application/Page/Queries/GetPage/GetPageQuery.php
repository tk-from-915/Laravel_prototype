<?php

namespace App\Application\Page\Queries\GetPage;

class GetPageQuery
{
    public function __construct(
        public readonly ?int    $id   = null,
        public readonly ?string $slug = null,
    ) {}
}
