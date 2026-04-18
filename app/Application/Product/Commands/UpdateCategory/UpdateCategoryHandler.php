<?php

namespace App\Application\Product\Commands\UpdateCategory;

use App\Application\Product\Queries\GetCategory\CategoryDTO;
use App\Domain\Product\Repositories\CategoryRepositoryInterface;
use App\Domain\Product\ValueObjects\CategoryId;

class UpdateCategoryHandler
{
    public function __construct(private readonly CategoryRepositoryInterface $categories) {}

    public function handle(UpdateCategoryCommand $command): CategoryDTO
    {
        $categoryId = new CategoryId($command->id);

        $category = $this->categories->findById($categoryId)
            ?? throw new \GraphQL\Error\UserError("Category not found: {$command->id}");

        if ($this->categories->existsBySlug($command->slug, $categoryId)) {
            throw new \GraphQL\Error\UserError("Slug already exists: {$command->slug}");
        }

        $category->update($command->slug, $command->name);

        $updated = $this->categories->update($category);

        return CategoryDTO::fromEntity($updated);
    }
}
