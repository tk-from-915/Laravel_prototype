<?php

namespace App\Application\Page\Queries\GetPage;

use App\Domain\Page\Entities\Page;

class PageDTO
{
    public function __construct(
        public readonly int    $id,
        public readonly string $slug,
        public readonly string $title,
        public readonly string $body,
        public readonly string $status,
        public readonly int    $author_id,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {}

    public static function fromEntity(Page $page): self
    {
        return new self(
            id:         $page->id()->value(),
            slug:       $page->slug(),
            title:      $page->title(),
            body:       $page->body(),
            status:     $page->status()->value,
            author_id:  $page->authorId()->value(),
            created_at: $page->createdAt()->format('Y-m-d H:i:s'),
            updated_at: $page->updatedAt()->format('Y-m-d H:i:s'),
        );
    }
}
