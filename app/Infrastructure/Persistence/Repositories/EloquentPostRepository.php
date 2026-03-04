<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Content\Entities\Post;
use App\Domain\Content\Repositories\PostRepositoryInterface;
use App\Domain\Content\ValueObjects\PostBody;
use App\Domain\Content\ValueObjects\PostId;
use App\Domain\Content\ValueObjects\PostStatus;
use App\Domain\Content\ValueObjects\PostTitle;
use App\Domain\Content\ValueObjects\PostType;
use App\Infrastructure\Persistence\Eloquent\PostModel;

class EloquentPostRepository implements PostRepositoryInterface
{
    public function findById(PostId $id): ?Post
    {
        $model = PostModel::find($id->value());

        return $model ? $this->toEntity($model) : null;
    }

    public function create(
        PostType $type,
        PostTitle $title,
        PostBody $body,
        PostStatus $status,
        int $authorId,
    ): Post {
        $model = PostModel::create([
            'type'      => $type->value,
            'title'     => $title->value(),
            'body'      => $body->value(),
            'status'    => $status->value,
            'author_id' => $authorId,
        ]);

        return $this->toEntity($model);
    }

    public function update(Post $post): void
    {
        PostModel::where('id', $post->id()->value())->update([
            'title'        => $post->title()->value(),
            'body'         => $post->body()->value(),
            'status'       => $post->status()->value,
            'published_at' => $post->publishedAt()?->format('Y-m-d H:i:s'),
        ]);
    }

    public function delete(PostId $id): void
    {
        PostModel::destroy($id->value());
    }

    public function findAll(
        int $page,
        int $perPage,
        ?PostType $type = null,
        ?PostStatus $status = null,
    ): array {
        $query = PostModel::orderByDesc('created_at');

        if ($type !== null) {
            $query->where('type', $type->value);
        }
        if ($status !== null) {
            $query->where('status', $status->value);
        }

        return $query->paginate($perPage, page: $page)
            ->map(fn ($model) => $this->toEntity($model))
            ->all();
    }

    public function countAll(?PostType $type = null, ?PostStatus $status = null): int
    {
        $query = PostModel::query();

        if ($type !== null) {
            $query->where('type', $type->value);
        }
        if ($status !== null) {
            $query->where('status', $status->value);
        }

        return $query->count();
    }

    private function toEntity(PostModel $model): Post
    {
        return Post::reconstitute(
            id: new PostId($model->id),
            type: $model->type instanceof PostType ? $model->type : PostType::from($model->type),
            title: new PostTitle($model->title),
            body: new PostBody($model->body),
            status: $model->status instanceof PostStatus ? $model->status : PostStatus::from($model->status),
            authorId: $model->author_id,
            publishedAt: $model->published_at
                ? new \DateTimeImmutable($model->published_at->toDateTimeString())
                : null,
            createdAt: new \DateTimeImmutable($model->created_at->toDateTimeString()),
            updatedAt: $model->updated_at
                ? new \DateTimeImmutable($model->updated_at->toDateTimeString())
                : null,
        );
    }
}
