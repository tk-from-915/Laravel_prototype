<?php

namespace App\Application\Content\Queries\GetPost;

final class GetPostQuery
{
    public function __construct(
        public readonly int $id,
    ) {}
}
