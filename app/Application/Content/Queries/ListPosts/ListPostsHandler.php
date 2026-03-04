<?php

namespace App\Application\Content\Queries\ListPosts;

use App\Application\Content\Queries\GetPost\PostDTO;
use App\Domain\Content\Repositories\PostRepositoryInterface;
use App\Domain\Content\ValueObjects\PostStatus;
use App\Domain\Content\ValueObjects\PostType;

class ListPostsHandler
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    /**
     * @return array{ data: PostDTO[], total: int, per_page: int, current_page: int }
     */
    public function handle(ListPostsQuery $query): array
    {
        $type   = $query->type   !== null ? PostType::from($query->type)     : null;
        $status = $query->status !== null ? PostStatus::from($query->status) : null;

        $posts = $this->postRepository->findAll($query->page, $query->perPage, $type, $status);

        return [
            'data'         => array_map(fn ($p) => PostDTO::fromEntity($p), $posts),
            'total'        => $this->postRepository->countAll($type, $status),
            'per_page'     => $query->perPage,
            'current_page' => $query->page,
        ];
    }
}
