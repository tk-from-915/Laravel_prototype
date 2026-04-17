<?php

namespace App\Application\Product\Commands\DeleteCategory;

use App\Domain\Product\Repositories\CategoryRepositoryInterface;
use App\Domain\Product\ValueObjects\CategoryId;

class DeleteCategoryHandler
{
    public function __construct(private readonly CategoryRepositoryInterface $categories) {}

    public function handle(DeleteCategoryCommand $command): bool
    {
        $categoryId = new CategoryId($command->id);

        $this->categories->findById($categoryId)
            ?? throw new \GraphQL\Error\UserError("Category not found: {$command->id}");

        if ($this->categories->hasProducts($categoryId)) {
            throw new \GraphQL\Error\UserError("Cannot delete category: products are still linked.");
        }

        $this->categories->delete($categoryId);

        return true;
    }
}
