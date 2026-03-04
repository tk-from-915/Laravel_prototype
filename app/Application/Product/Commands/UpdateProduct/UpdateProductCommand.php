<?php

namespace App\Application\Product\Commands\UpdateProduct;

class UpdateProductCommand
{
    public function __construct(
        public readonly int     $id,
        public readonly ?string $name,
        public readonly ?string $description,
        public readonly ?int    $price,
        public readonly ?string $status,
        /** @var int[]|null */
        public readonly ?array  $categoryIds,
    ) {}
}
