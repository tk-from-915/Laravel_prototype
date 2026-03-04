<?php

namespace App\Application\Content\Queries\GetPost;

use App\Domain\Content\Entities\Post;

final class PostDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $type,
        public readonly string $title,
        public readonly string $body,
        public readonly string $status,
        public readonly int $author_id,
        public readonly string $created_at,
        public readonly ?string $updated_at,
        public readonly ?string $published_at,
    ) {}

    public static function fromEntity(Post $post): self
    {
        return new self(
            id: $post->id()->value(),
            type: $post->type()->value,
            title: $post->title()->value(),
            body: $post->body()->value(),
            status: $post->status()->value,
            author_id: $post->authorId(),
            created_at: $post->createdAt()->format('Y-m-d H:i:s'),
            updated_at: $post->updatedAt()?->format('Y-m-d H:i:s'),
            published_at: $post->publishedAt()?->format('Y-m-d H:i:s'),
        );
    }
}
