<?php

namespace App\Application\Product\Commands\CreateComment;

use App\Application\Product\Queries\ListComments\ProductCommentDTO;
use App\Domain\Product\Repositories\ProductCommentRepositoryInterface;

class CreateCommentHandler
{
    public function __construct(private readonly ProductCommentRepositoryInterface $comments) {}

    public function handle(CreateCommentCommand $command): ProductCommentDTO
    {
        $comment = $this->comments->create(
            productId: $command->productId,
            name:      $command->name,
            body:      $command->body,
        );

        return ProductCommentDTO::fromEntity($comment);
    }
}
