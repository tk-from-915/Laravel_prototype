<?php

namespace App\Application\Content\Commands\PublishPost;

use App\Application\Content\Queries\GetPost\PostDTO;
use App\Domain\Content\Repositories\PostRepositoryInterface;
use App\Domain\Content\ValueObjects\PostId;

class PublishPostHandler
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    public function handle(PublishPostCommand $command): PostDTO
    {
        $post = $this->postRepository->findById(new PostId($command->id));

        if ($post === null) {
            throw new \DomainException("Post {$command->id} not found.");
        }

        $command->publish ? $post->publish() : $post->unpublish();

        $this->postRepository->update($post);

        return PostDTO::fromEntity($post);
    }
}
