<?php

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Entities\Category;
use App\Domain\Product\ValueObjects\CategoryId;

interface CategoryRepositoryInterface
{
    public function findById(CategoryId $id): ?Category;

    /** @return Category[] */
    public function findAll(): array;

    public function countAll(): int;
}
