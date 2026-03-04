<?php

namespace App\Application\Content\Commands\CreatePost;

use App\Application\Content\Queries\GetPost\PostDTO;
use App\Domain\Content\Repositories\PostRepositoryInterface;
use App\Domain\Content\ValueObjects\PostBody;
use App\Domain\Content\ValueObjects\PostStatus;
use App\Domain\Content\ValueObjects\PostTitle;
use App\Domain\Content\ValueObjects\PostType;

class CreatePostHandler
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    public function handle(CreatePostCommand $command): PostDTO
    {
        $post = $this->postRepository->create(
            type: PostType::from($command->type),
            title: new PostTitle($command->title),
            body: new PostBody($command->body),
            status: PostStatus::from($command->status),
            authorId: $command->authorId,
        );

        return PostDTO::fromEntity($post);
    }
}
