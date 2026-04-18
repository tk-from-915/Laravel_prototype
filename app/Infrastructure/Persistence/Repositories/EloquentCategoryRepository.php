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

    public function existsBySlug(string $slug, ?CategoryId $excludeId = null): bool
    {
        $query = CategoryModel::where('slug', $slug);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId->value());
        }

        return $query->exists();
    }

    public function create(string $slug, string $name): Category
    {
        $model = CategoryModel::create(['slug' => $slug, 'name' => $name]);

        return $this->toEntity($model);
    }

    public function update(Category $category): Category
    {
        $model = CategoryModel::findOrFail($category->id()->value());

        $model->update([
            'slug' => $category->slug(),
            'name' => $category->name()->value(),
        ]);

        return $this->toEntity($model->fresh());
    }

    public function delete(CategoryId $id): void
    {
        CategoryModel::findOrFail($id->value())->delete();
    }

    public function hasProducts(CategoryId $id): bool
    {
        return CategoryModel::findOrFail($id->value())
            ->products()
            ->exists();
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
