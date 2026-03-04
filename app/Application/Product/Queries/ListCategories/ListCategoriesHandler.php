<?php

namespace App\Application\Product\Queries\ListCategories;

use App\Application\Product\Queries\GetCategory\CategoryDTO;
use App\Domain\Product\Repositories\CategoryRepositoryInterface;

class ListCategoriesHandler
{
    public function __construct(private readonly CategoryRepositoryInterface $categories) {}

    public function handle(ListCategoriesQuery $query): array
    {
        $categories = $this->categories->findAll();

        return array_map(fn ($cat) => CategoryDTO::fromEntity($cat), $categories);
    }
}
