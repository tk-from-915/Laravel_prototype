<?php

namespace App\Domain\Page\Repositories;

use App\Domain\Page\Entities\Page;
use App\Domain\Page\ValueObjects\PageId;

interface PageRepositoryInterface
{
    public function findById(PageId $id): ?Page;

    public function findBySlug(string $slug): ?Page;

    public function create(
        string $slug,
        string $title,
        string $body,
        string $status,
        int    $authorId,
    ): Page;

    public function update(Page $page): Page;

    public function delete(PageId $id): void;

    /** @return Page[] */
    public function findAll(int $page, int $perPage, ?string $status = null): array;

    public function countAll(?string $status = null): int;
}
