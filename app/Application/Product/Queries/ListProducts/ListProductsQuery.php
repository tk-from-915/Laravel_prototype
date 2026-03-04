<?php

namespace App\Application\Product\Queries\ListProducts;

class ListProductsQuery
{
    public function __construct(
        public readonly int    $page     = 1,
        public readonly int    $perPage  = 15,
        public readonly ?string $status  = null,
        public readonly ?int   $categoryId = null,
    ) {}
}
