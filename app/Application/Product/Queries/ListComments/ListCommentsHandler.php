<?php

namespace App\Application\Product\Queries\ListComments;

use App\Domain\Product\Repositories\ProductCommentRepositoryInterface;
use App\Domain\Product\ValueObjects\CommentStatus;

class ListCommentsHandler
{
    public function __construct(private readonly ProductCommentRepositoryInterface $comments) {}

    /** @return ProductCommentDTO[] */
    public function handle(ListCommentsQuery $query): array
    {
        $status = $query->status !== null ? CommentStatus::from($query->status) : null;

        $comments = $this->comments->findByProductId($query->productId, $status);

        return array_map(fn ($c) => ProductCommentDTO::fromEntity($c), $comments);
    }
}
