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

    public function existsBySlug(string $slug, ?CategoryId $excludeId = null): bool;

    public function create(string $slug, string $name): Category;

    public function update(Category $category): Category;

    public function delete(CategoryId $id): void;

    public function hasProducts(CategoryId $id): bool;
}
