<?php

namespace App\Application\Product\Commands\UpdateCategory;

class UpdateCategoryCommand
{
    public function __construct(
        public readonly int    $id,
        public readonly string $slug,
        public readonly string $name,
    ) {}
}
