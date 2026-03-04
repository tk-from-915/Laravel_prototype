<?php

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Entities\Product;
use App\Domain\Product\ValueObjects\ProductId;

interface ProductRepositoryInterface
{
    public function findById(ProductId $id): ?Product;

    public function create(
        string  $name,
        ?string $description,
        int     $price,
        string  $status,
        int     $authorId,
        array   $categoryIds,
    ): Product;

    public function update(Product $product): Product;

    public function delete(ProductId $id): void;

    /**
     * @return Product[]
     */
    public function findAll(
        int     $page,
        int     $perPage,
        ?string $status   = null,
        ?int    $categoryId = null,
    ): array;

    public function countAll(?string $status = null, ?int $categoryId = null): int;
}
