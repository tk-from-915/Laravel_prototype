<?php

namespace App\Application\Product\Commands\CreateProduct;

use App\Application\Product\Queries\GetCategory\CategoryDTO;
use App\Application\Product\Queries\GetProduct\ProductDTO;
use App\Domain\Product\Repositories\CategoryRepositoryInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;

class CreateProductHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface  $products,
        private readonly CategoryRepositoryInterface $categories,
    ) {}

    public function handle(CreateProductCommand $command): ProductDTO
    {
        $product = $this->products->create(
            name:        $command->name,
            description: $command->description,
            price:       $command->price,
            status:      $command->status,
            authorId:    $command->authorId,
            categoryIds: $command->categoryIds,
        );

        $categoryDTOs = $this->resolveCategoryDTOs($product->categoryIds());

        return ProductDTO::fromEntity($product, $categoryDTOs);
    }

    private function resolveCategoryDTOs(array $categoryIds): array
    {
        return array_values(array_filter(
            array_map(
                fn ($cid) => ($cat = $this->categories->findById($cid)) ? CategoryDTO::fromEntity($cat) : null,
                $categoryIds,
            ),
        ));
    }
}
