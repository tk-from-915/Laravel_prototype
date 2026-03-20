<?php

namespace App\Application\Product\Queries\ListAllComments;

use App\Application\Product\Queries\ListComments\ProductCommentDTO;
use App\Domain\Product\Repositories\ProductCommentRepositoryInterface;
use App\Domain\Product\ValueObjects\CommentStatus;

class ListAllCommentsHandler
{
    public function __construct(private readonly ProductCommentRepositoryInterface $comments) {}

    /** @return ProductCommentDTO[] */
    public function handle(ListAllCommentsQuery $query): array
    {
        $status = $query->status !== null ? CommentStatus::from($query->status) : null;

        $comments = $this->comments->findAll($status);

        return array_map(fn ($c) => ProductCommentDTO::fromEntity($c), $comments);
    }
}
