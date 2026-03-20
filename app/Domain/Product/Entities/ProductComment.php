<?php

namespace App\Domain\Product\Entities;

use App\Domain\Product\ValueObjects\ProductCommentId;
use App\Domain\Product\ValueObjects\ProductId;
use App\Domain\Product\ValueObjects\CommentStatus;

class ProductComment
{
    private function __construct(
        private readonly ProductCommentId   $id,
        private readonly ProductId          $productId,
        private readonly string             $name,
        private readonly string             $body,
        private CommentStatus               $status,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
    ) {}

    public static function reconstitute(
        int    $id,
        int    $productId,
        string $name,
        string $body,
        string $status,
        string $createdAt,
        string $updatedAt,
    ): self {
        return new self(
            new ProductCommentId($id),
            new ProductId($productId),
            $name,
            $body,
            CommentStatus::from($status),
            new \DateTimeImmutable($createdAt),
            new \DateTimeImmutable($updatedAt),
        );
    }

    public function approve(): void
    {
        $this->status    = CommentStatus::Approved;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function reject(): void
    {
        $this->status    = CommentStatus::Rejected;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function updateStatus(CommentStatus $status): void
    {
        $this->status    = $status;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function id(): ProductCommentId          { return $this->id; }
    public function productId(): ProductId          { return $this->productId; }
    public function name(): string                  { return $this->name; }
    public function body(): string                  { return $this->body; }
    public function status(): CommentStatus         { return $this->status; }
    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }
}
