<?php

namespace App\Application\Product\Commands\UpdateProduct;

use App\Application\Product\Queries\GetCategory\CategoryDTO;
use App\Application\Product\Queries\GetProduct\ProductDTO;
use App\Domain\Product\Repositories\CategoryRepositoryInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\ProductId;
use App\Domain\Product\ValueObjects\ProductStatus;

class UpdateProductHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface  $products,
        private readonly CategoryRepositoryInterface $categories,
    ) {}

    public function handle(UpdateProductCommand $command): ProductDTO
    {
        $productId = new ProductId($command->id);
        $product   = $this->products->findById($productId)
            ?? throw new \DomainException("Product not found: {$command->id}");

        $product->update($command->name, $command->description, $command->price);

        if ($command->status !== null) {
            $product->changeStatus(ProductStatus::from($command->status));
        }

        if ($command->categoryIds !== null) {
            $product->syncCategories($command->categoryIds);
        }

        $saved        = $this->products->update($product);
        $categoryDTOs = $this->resolveCategoryDTOs($saved->categoryIds());

        return ProductDTO::fromEntity($saved, $categoryDTOs);
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
