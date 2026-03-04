<?php

namespace App\Application\Product\Queries\ListProducts;

use App\Application\Product\Queries\GetCategory\CategoryDTO;
use App\Application\Product\Queries\GetProduct\ProductDTO;
use App\Domain\Product\Repositories\CategoryRepositoryInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;

class ListProductsHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface  $products,
        private readonly CategoryRepositoryInterface $categories,
    ) {}

    public function handle(ListProductsQuery $query): array
    {
        $items = $this->products->findAll(
            page:       $query->page,
            perPage:    $query->perPage,
            status:     $query->status,
            categoryId: $query->categoryId,
        );

        $total = $this->products->countAll($query->status, $query->categoryId);

        $data = array_map(function ($product) {
            $categoryDTOs = array_values(array_filter(
                array_map(
                    fn ($cid) => ($cat = $this->categories->findById($cid)) ? CategoryDTO::fromEntity($cat) : null,
                    $product->categoryIds(),
                ),
            ));
            return ProductDTO::fromEntity($product, $categoryDTOs);
        }, $items);

        return [
            'data'         => $data,
            'total'        => $total,
            'per_page'     => $query->perPage,
            'current_page' => $query->page,
        ];
    }
}
