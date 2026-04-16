<?php

namespace App\Application\Product\Commands\DeleteCategory;

class DeleteCategoryCommand
{
    public function __construct(
        public readonly int $id,
    ) {}
}
