<?php

namespace App\Application\Product\Commands\UpdateCommentStatus;

use App\Application\Product\Queries\ListComments\ProductCommentDTO;
use App\Domain\Product\Repositories\ProductCommentRepositoryInterface;
use App\Domain\Product\ValueObjects\CommentStatus;
use App\Domain\Product\ValueObjects\ProductCommentId;

class UpdateCommentStatusHandler
{
    public function __construct(private readonly ProductCommentRepositoryInterface $comments) {}

    public function handle(UpdateCommentStatusCommand $command): ProductCommentDTO
    {
        $comment = $this->comments->findById(new ProductCommentId($command->id));

        $comment->updateStatus(CommentStatus::from($command->status));

        $updated = $this->comments->update($comment);

        return ProductCommentDTO::fromEntity($updated);
    }
}
