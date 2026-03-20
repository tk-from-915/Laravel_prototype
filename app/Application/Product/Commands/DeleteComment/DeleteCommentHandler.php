<?php

namespace App\Application\Product\Commands\DeleteComment;

use App\Domain\Product\Repositories\ProductCommentRepositoryInterface;
use App\Domain\Product\ValueObjects\ProductCommentId;

class DeleteCommentHandler
{
    public function __construct(private readonly ProductCommentRepositoryInterface $comments) {}

    public function handle(DeleteCommentCommand $command): bool
    {
        $this->comments->delete(new ProductCommentId($command->id));
        return true;
    }
}
