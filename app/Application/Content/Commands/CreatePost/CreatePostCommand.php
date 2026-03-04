<?php

namespace App\Application\Content\Commands\CreatePost;

final class CreatePostCommand
{
    public function __construct(
        public readonly string $type,
        public readonly string $title,
        public readonly string $body,
        public readonly int $authorId,
        public readonly string $status = 'draft',
    ) {}
}
