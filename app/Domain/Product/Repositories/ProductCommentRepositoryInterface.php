<?php

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Entities\ProductComment;
use App\Domain\Product\ValueObjects\ProductCommentId;
use App\Domain\Product\ValueObjects\CommentStatus;

interface ProductCommentRepositoryInterface
{
    public function create(int $productId, string $name, string $body): ProductComment;

    /** @return ProductComment[] */
    public function findByProductId(int $productId, ?CommentStatus $status = null): array;

    public function findById(ProductCommentId $id): ?ProductComment;

    public function update(ProductComment $comment): ProductComment;

    public function delete(ProductCommentId $id): void;

    /** @return ProductComment[] */
    public function findAll(?CommentStatus $status = null): array;
}
