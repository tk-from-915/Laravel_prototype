<?php

namespace App\Application\Product\Commands\CreateCategory;

use App\Application\Product\Queries\GetCategory\CategoryDTO;
use App\Domain\Product\Repositories\CategoryRepositoryInterface;
use App\Domain\Product\ValueObjects\CategoryId;

class CreateCategoryHandler
{
    public function __construct(private readonly CategoryRepositoryInterface $categories) {}

    public function handle(CreateCategoryCommand $command): CategoryDTO
    {
        if ($this->categories->existsBySlug($command->slug)) {
            throw new \DomainException("Slug already exists: {$command->slug}");
        }

        $category = $this->categories->create($command->slug, $command->name);

        return CategoryDTO::fromEntity($category);
    }
}
