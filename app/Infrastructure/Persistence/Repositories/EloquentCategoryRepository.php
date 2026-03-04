<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Product\Entities\Category;
use App\Domain\Product\Repositories\CategoryRepositoryInterface;
use App\Domain\Product\ValueObjects\CategoryId;
use App\Infrastructure\Persistence\Eloquent\CategoryModel;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function findById(CategoryId $id): ?Category
    {
        $model = CategoryModel::find($id->value());
        return $model ? $this->toEntity($model) : null;
    }

    public function findAll(): array
    {
        return CategoryModel::orderBy('id')->get()
            ->map(fn ($m) => $this->toEntity($m))
            ->all();
    }

    public function countAll(): int
    {
        return CategoryModel::count();
    }

    private function toEntity(CategoryModel $model): Category
    {
        return Category::reconstitute(
            id:        $model->id,
            name:      $model->name,
            slug:      $model->slug,
            createdAt: $model->created_at->toDateTimeString(),
            updatedAt: $model->updated_at->toDateTimeString(),
        );
    }
}
