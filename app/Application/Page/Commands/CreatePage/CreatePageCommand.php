<?php

namespace App\Application\Page\Commands\CreatePage;

class CreatePageCommand
{
    public function __construct(
        public readonly string $slug,
        public readonly string $title,
        public readonly string $body,
        public readonly string $status,
        public readonly int    $authorId,
    ) {}
}
