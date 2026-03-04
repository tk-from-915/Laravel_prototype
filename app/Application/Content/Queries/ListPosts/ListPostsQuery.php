<?php

namespace App\Application\Content\Queries\ListPosts;

final class ListPostsQuery
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $type = null,
        public readonly ?string $status = null,
    ) {}
}
