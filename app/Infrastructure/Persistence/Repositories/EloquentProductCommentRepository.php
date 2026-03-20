<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Product\Entities\ProductComment;
use App\Domain\Product\Repositories\ProductCommentRepositoryInterface;
use App\Domain\Product\ValueObjects\CommentStatus;
use App\Domain\Product\ValueObjects\ProductCommentId;
use App\Infrastructure\Persistence\Eloquent\ProductCommentModel;

class EloquentProductCommentRepository implements ProductCommentRepositoryInterface
{
    public function create(int $productId, string $name, string $body): ProductComment
    {
        $model = ProductCommentModel::create([
            'product_id' => $productId,
            'name'       => $name,
            'body'       => $body,
            'status'     => CommentStatus::Pending->value,
        ]);

        return $this->toEntity($model);
    }

    public function findByProductId(int $productId, ?CommentStatus $status = null): array
    {
        $query = ProductCommentModel::where('product_id', $productId)
            ->orderByDesc('created_at');

        if ($status !== null) {
            $query->where('status', $status->value);
        }

        return $query->get()->map(fn ($m) => $this->toEntity($m))->all();
    }

    public function findById(ProductCommentId $id): ?ProductComment
    {
        $model = ProductCommentModel::find($id->value());
        return $model ? $this->toEntity($model) : null;
    }

    public function update(ProductComment $comment): ProductComment
    {
        $model = ProductCommentModel::findOrFail($comment->id()->value());
        $model->update(['status' => $comment->status()->value]);

        return $this->toEntity($model);
    }

    public function delete(ProductCommentId $id): void
    {
        ProductCommentModel::findOrFail($id->value())->delete();
    }

    public function findAll(?CommentStatus $status = null): array
    {
        $query = ProductCommentModel::orderByDesc('created_at');

        if ($status !== null) {
            $query->where('status', $status->value);
        }

        return $query->get()->map(fn ($m) => $this->toEntity($m))->all();
    }

    private function toEntity(ProductCommentModel $model): ProductComment
    {
        return ProductComment::reconstitute(
            id:        $model->id,
            productId: $model->product_id,
            name:      $model->name,
            body:      $model->body,
            status:    $model->status->value,
            createdAt: $model->created_at->toDateTimeString(),
            updatedAt: $model->updated_at->toDateTimeString(),
        );
    }
}
