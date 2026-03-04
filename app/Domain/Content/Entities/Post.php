<?php

namespace App\Domain\Content\Entities;

use App\Domain\Content\ValueObjects\PostBody;
use App\Domain\Content\ValueObjects\PostId;
use App\Domain\Content\ValueObjects\PostStatus;
use App\Domain\Content\ValueObjects\PostTitle;
use App\Domain\Content\ValueObjects\PostType;

class Post
{
    private function __construct(
        private readonly PostId $id,
        private readonly PostType $type,
        private PostTitle $title,
        private PostBody $body,
        private PostStatus $status,
        private readonly int $authorId,
        private ?\DateTimeImmutable $publishedAt,
        private readonly \DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {}

    /** DBから再構成するときに使うファクトリ */
    public static function reconstitute(
        PostId $id,
        PostType $type,
        PostTitle $title,
        PostBody $body,
        PostStatus $status,
        int $authorId,
        ?\DateTimeImmutable $publishedAt,
        \DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt = null,
    ): self {
        return new self(
            $id, $type, $title, $body, $status,
            $authorId, $publishedAt, $createdAt, $updatedAt,
        );
    }

    // --- Getters ---

    public function id(): PostId { return $this->id; }
    public function type(): PostType { return $this->type; }
    public function title(): PostTitle { return $this->title; }
    public function body(): PostBody { return $this->body; }
    public function status(): PostStatus { return $this->status; }
    public function authorId(): int { return $this->authorId; }
    public function publishedAt(): ?\DateTimeImmutable { return $this->publishedAt; }
    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    public function updatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }

    // --- Behaviors ---

    public function update(?PostTitle $title, ?PostBody $body): void
    {
        if ($title !== null) {
            $this->title = $title;
        }
        if ($body !== null) {
            $this->body = $body;
        }
    }

    public function publish(): void
    {
        if ($this->status === PostStatus::Published) {
            return;
        }
        $this->status      = PostStatus::Published;
        $this->publishedAt = new \DateTimeImmutable();
    }

    public function unpublish(): void
    {
        $this->status      = PostStatus::Draft;
        $this->publishedAt = null;
    }

    public function isPublished(): bool
    {
        return $this->status === PostStatus::Published;
    }
}
