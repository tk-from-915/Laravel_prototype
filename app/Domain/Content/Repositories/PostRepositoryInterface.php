<?php

namespace App\Domain\Content\Repositories;

use App\Domain\Content\Entities\Post;
use App\Domain\Content\ValueObjects\PostBody;
use App\Domain\Content\ValueObjects\PostId;
use App\Domain\Content\ValueObjects\PostStatus;
use App\Domain\Content\ValueObjects\PostTitle;
use App\Domain\Content\ValueObjects\PostType;

interface PostRepositoryInterface
{
    public function findById(PostId $id): ?Post;

    /**
     * 新規投稿を DB に挿入し、ID が付与されたエンティティを返す。
     */
    public function create(
        PostType $type,
        PostTitle $title,
        PostBody $body,
        PostStatus $status,
        int $authorId,
    ): Post;

    /** 既存投稿の変更を DB に反映する */
    public function update(Post $post): void;

    public function delete(PostId $id): void;

    /**
     * @return Post[]
     */
    public function findAll(
        int $page,
        int $perPage,
        ?PostType $type = null,
        ?PostStatus $status = null,
    ): array;

    public function countAll(?PostType $type = null, ?PostStatus $status = null): int;
}
