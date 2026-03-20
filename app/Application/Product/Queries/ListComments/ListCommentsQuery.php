<?php

namespace App\Application\Product\Queries\ListComments;

class ListCommentsQuery
{
    public function __construct(
        public readonly int     $productId,
        public readonly ?string $status = null,
    ) {}
}
