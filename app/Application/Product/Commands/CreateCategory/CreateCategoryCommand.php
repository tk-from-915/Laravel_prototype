<?php

namespace App\Application\Product\Commands\CreateCategory;

class CreateCategoryCommand
{
    public function __construct(
        public readonly string $slug,
        public readonly string $name,
    ) {}
}
