<?php

namespace App\Application\Product\Queries\ListComments;

use App\Domain\Product\Entities\ProductComment;

class ProductCommentDTO
{
    public function __construct(
        public readonly int    $id,
        public readonly int    $product_id,
        public readonly string $name,
        public readonly string $body,
        public readonly string $status,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {}

    public static function fromEntity(ProductComment $comment): self
    {
        return new self(
            id:         $comment->id()->value(),
            product_id: $comment->productId()->value(),
            name:       $comment->name(),
            body:       $comment->body(),
            status:     $comment->status()->value,
            created_at: $comment->createdAt()->format('Y-m-d H:i:s'),
            updated_at: $comment->updatedAt()->format('Y-m-d H:i:s'),
        );
    }
}
