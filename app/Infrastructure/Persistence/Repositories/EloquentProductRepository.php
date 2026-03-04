<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Product\Entities\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\ProductId;
use App\Infrastructure\Persistence\Eloquent\ProductModel;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function findById(ProductId $id): ?Product
    {
        $model = ProductModel::with('categories')->find($id->value());
        return $model ? $this->toEntity($model) : null;
    }

    public function create(
        string  $name,
        ?string $description,
        int     $price,
        string  $status,
        int     $authorId,
        array   $categoryIds,
    ): Product {
        $model = ProductModel::create([
            'name'        => $name,
            'description' => $description,
            'price'       => $price,
            'status'      => $status,
            'author_id'   => $authorId,
        ]);

        $model->categories()->sync($categoryIds);
        $model->load('categories');

        return $this->toEntity($model);
    }

    public function update(Product $product): Product
    {
        $model = ProductModel::findOrFail($product->id()->value());

        $model->update([
            'name'        => $product->name()->value(),
            'description' => $product->description()?->value(),
            'price'       => $product->price()->value(),
            'status'      => $product->status()->value,
        ]);

        $model->categories()->sync(
            array_map(fn ($cid) => $cid->value(), $product->categoryIds()),
        );

        $model->load('categories');

        return $this->toEntity($model);
    }

    public function delete(ProductId $id): void
    {
        ProductModel::findOrFail($id->value())->delete();
    }

    public function findAll(int $page, int $perPage, ?string $status = null, ?int $categoryId = null): array
    {
        $query = ProductModel::with('categories')->orderByDesc('created_at');

        if ($status !== null)     { $query->where('status', $status); }
        if ($categoryId !== null) {
            $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categoryId));
        }

        return $query->forPage($page, $perPage)->get()
            ->map(fn ($m) => $this->toEntity($m))
            ->all();
    }

    public function countAll(?string $status = null, ?int $categoryId = null): int
    {
        $query = ProductModel::query();

        if ($status !== null)     { $query->where('status', $status); }
        if ($categoryId !== null) {
            $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categoryId));
        }

        return $query->count();
    }

    private function toEntity(ProductModel $model): Product
    {
        $categoryIds = $model->relationLoaded('categories')
            ? $model->categories->pluck('id')->map(fn ($id) => (int) $id)->all()
            : [];

        return Product::reconstitute(
            id:          $model->id,
            name:        $model->name,
            description: $model->description,
            price:       $model->price,
            status:      $model->status->value,
            authorId:    $model->author_id,
            categoryIds: $categoryIds,
            createdAt:   $model->created_at->toDateTimeString(),
            updatedAt:   $model->updated_at->toDateTimeString(),
        );
    }
}
