<?php

namespace App\Application\Product\Commands\CreateProduct;

class CreateProductCommand
{
    public function __construct(
        public readonly string  $name,
        public readonly ?string $description,
        public readonly int     $price,
        public readonly string  $status,
        public readonly int     $authorId,
        /** @var int[] */
        public readonly array   $categoryIds,
    ) {}
}
