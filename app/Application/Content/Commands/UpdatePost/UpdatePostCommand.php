<?php

namespace App\Application\Content\Commands\UpdatePost;

final class UpdatePostCommand
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $title = null,
        public readonly ?string $body = null,
    ) {}
}
