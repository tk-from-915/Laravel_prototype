<?php

namespace App\Application\Content\Queries\GetPost;

use App\Domain\Content\Repositories\PostRepositoryInterface;
use App\Domain\Content\ValueObjects\PostId;

class GetPostHandler
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    public function handle(GetPostQuery $query): ?PostDTO
    {
        $post = $this->postRepository->findById(new PostId($query->id));

        return $post !== null ? PostDTO::fromEntity($post) : null;
    }
}
