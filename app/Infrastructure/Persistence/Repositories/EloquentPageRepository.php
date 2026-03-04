<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Page\Entities\Page;
use App\Domain\Page\Repositories\PageRepositoryInterface;
use App\Domain\Page\ValueObjects\PageId;
use App\Infrastructure\Persistence\Eloquent\PageModel;

class EloquentPageRepository implements PageRepositoryInterface
{
    public function findById(PageId $id): ?Page
    {
        $model = PageModel::find($id->value());
        return $model ? $this->toEntity($model) : null;
    }

    public function findBySlug(string $slug): ?Page
    {
        $model = PageModel::where('slug', $slug)->first();
        return $model ? $this->toEntity($model) : null;
    }

    public function create(
        string $slug,
        string $title,
        string $body,
        string $status,
        int    $authorId,
    ): Page {
        $model = PageModel::create([
            'slug'      => $slug,
            'title'     => $title,
            'body'      => $body,
            'status'    => $status,
            'author_id' => $authorId,
        ]);

        return $this->toEntity($model);
    }

    public function update(Page $page): Page
    {
        $model = PageModel::findOrFail($page->id()->value());

        $model->update([
            'title'  => $page->title(),
            'body'   => $page->body(),
            'status' => $page->status()->value,
        ]);

        return $this->toEntity($model->fresh());
    }

    public function delete(PageId $id): void
    {
        PageModel::findOrFail($id->value())->delete();
    }

    public function findAll(int $page, int $perPage, ?string $status = null): array
    {
        $query = PageModel::orderBy('slug');

        if ($status !== null) { $query->where('status', $status); }

        return $query->forPage($page, $perPage)->get()
            ->map(fn ($m) => $this->toEntity($m))
            ->all();
    }

    public function countAll(?string $status = null): int
    {
        $query = PageModel::query();

        if ($status !== null) { $query->where('status', $status); }

        return $query->count();
    }

    private function toEntity(PageModel $model): Page
    {
        return Page::reconstitute(
            id:        $model->id,
            slug:      $model->slug,
            title:     $model->title,
            body:      $model->body,
            status:    $model->status->value,
            authorId:  $model->author_id,
            createdAt: $model->created_at->toDateTimeString(),
            updatedAt: $model->updated_at->toDateTimeString(),
        );
    }
}
