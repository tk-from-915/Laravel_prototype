<?php

namespace App\Application\Content\Commands\DeletePost;

use App\Domain\Content\Repositories\PostRepositoryInterface;
use App\Domain\Content\ValueObjects\PostId;

class DeletePostHandler
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    public function handle(DeletePostCommand $command): bool
    {
        $postId = new PostId($command->id);

        if ($this->postRepository->findById($postId) === null) {
            throw new \DomainException("Post {$command->id} not found.");
        }

        $this->postRepository->delete($postId);

        return true;
    }
}
