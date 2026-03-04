<?php

namespace App\Domain\Page\Entities;

use App\Domain\Page\ValueObjects\PageId;
use App\Domain\Page\ValueObjects\PageStatus;
use App\Domain\User\ValueObjects\UserId;

class Page
{
    private function __construct(
        private readonly PageId             $id,
        private readonly string             $slug,
        private string                      $title,
        private string                      $body,
        private PageStatus                  $status,
        private readonly UserId             $authorId,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
    ) {}

    public static function reconstitute(
        int    $id,
        string $slug,
        string $title,
        string $body,
        string $status,
        int    $authorId,
        string $createdAt,
        string $updatedAt,
    ): self {
        return new self(
            new PageId($id),
            $slug,
            $title,
            $body,
            PageStatus::from($status),
            new UserId($authorId),
            new \DateTimeImmutable($createdAt),
            new \DateTimeImmutable($updatedAt),
        );
    }

    public function update(?string $title, ?string $body): void
    {
        if ($title !== null) { $this->title = $title; }
        if ($body  !== null) { $this->body  = $body; }
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function publish(): void
    {
        $this->status    = PageStatus::Published;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function unpublish(): void
    {
        $this->status    = PageStatus::Draft;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function isPublished(): bool { return $this->status === PageStatus::Published; }

    public function id(): PageId                   { return $this->id; }
    public function slug(): string                 { return $this->slug; }
    public function title(): string                { return $this->title; }
    public function body(): string                 { return $this->body; }
    public function status(): PageStatus           { return $this->status; }
    public function authorId(): UserId             { return $this->authorId; }
    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }
}
