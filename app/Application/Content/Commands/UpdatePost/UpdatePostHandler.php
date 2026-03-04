<?php

namespace App\Application\Content\Commands\UpdatePost;

use App\Application\Content\Queries\GetPost\PostDTO;
use App\Domain\Content\Repositories\PostRepositoryInterface;
use App\Domain\Content\ValueObjects\PostBody;
use App\Domain\Content\ValueObjects\PostId;
use App\Domain\Content\ValueObjects\PostTitle;

class UpdatePostHandler
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    public function handle(UpdatePostCommand $command): PostDTO
    {
        $post = $this->postRepository->findById(new PostId($command->id));

        if ($post === null) {
            throw new \DomainException("Post {$command->id} not found.");
        }

        $post->update(
            title: $command->title !== null ? new PostTitle($command->title) : null,
            body:  $command->body  !== null ? new PostBody($command->body)   : null,
        );

        $this->postRepository->update($post);

        return PostDTO::fromEntity($post);
    }
}
