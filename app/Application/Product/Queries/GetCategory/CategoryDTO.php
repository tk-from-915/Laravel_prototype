<?php

namespace App\Application\Product\Queries\GetCategory;

use App\Domain\Product\Entities\Category;

class CategoryDTO
{
    public function __construct(
        public readonly int    $id,
        public readonly string $slug,
        public readonly string $name,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {}

    public static function fromEntity(Category $category): self
    {
        return new self(
            id:         $category->id()->value(),
            slug:       $category->slug(),
            name:       $category->name()->value(),
            created_at: $category->createdAt()->format('Y-m-d H:i:s'),
            updated_at: $category->updatedAt()->format('Y-m-d H:i:s'),
        );
    }
}
