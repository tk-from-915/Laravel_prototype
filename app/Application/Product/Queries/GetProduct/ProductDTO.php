<?php

namespace App\Application\Product\Queries\GetProduct;

use App\Application\Product\Queries\GetCategory\CategoryDTO;
use App\Domain\Product\Entities\Product;

class ProductDTO
{
    /**
     * @param CategoryDTO[] $categories
     */
    public function __construct(
        public readonly int     $id,
        public readonly string  $name,
        public readonly ?string $description,
        public readonly int     $price,
        public readonly string  $status,
        public readonly int     $author_id,
        public readonly array   $categories,
        public readonly string  $created_at,
        public readonly string  $updated_at,
    ) {}

    public static function fromEntity(Product $product, array $categories = []): self
    {
        return new self(
            id:          $product->id()->value(),
            name:        $product->name()->value(),
            description: $product->description()?->value(),
            price:       $product->price()->value(),
            status:      $product->status()->value,
            author_id:   $product->authorId()->value(),
            categories:  $categories,
            created_at:  $product->createdAt()->format('Y-m-d H:i:s'),
            updated_at:  $product->updatedAt()->format('Y-m-d H:i:s'),
        );
    }
}
