<?php

namespace App\Application\Product\Queries\GetProduct;

use App\Application\Product\Queries\GetCategory\CategoryDTO;
use App\Domain\Product\Repositories\CategoryRepositoryInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\ProductId;

class GetProductHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface  $products,
        private readonly CategoryRepositoryInterface $categories,
    ) {}

    public function handle(GetProductQuery $query): ?ProductDTO
    {
        $product = $this->products->findById(new ProductId($query->id));

        if ($product === null) {
            return null;
        }

        $categoryDTOs = array_values(array_filter(
            array_map(
                fn ($cid) => ($cat = $this->categories->findById($cid)) ? CategoryDTO::fromEntity($cat) : null,
                $product->categoryIds(),
            ),
        ));

        return ProductDTO::fromEntity($product, $categoryDTOs);
    }
}
