<?php

namespace App\Application\Product\Commands\CreateComment;

class CreateCommentCommand
{
    public function __construct(
        public readonly int    $productId,
        public readonly string $name,
        public readonly string $body,
    ) {}
}
