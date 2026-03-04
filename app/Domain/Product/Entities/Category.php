<?php

namespace App\Domain\Product\Entities;

use App\Domain\Product\ValueObjects\CategoryId;
use App\Domain\Product\ValueObjects\CategoryName;

class Category
{
    private function __construct(
        private readonly CategoryId   $id,
        private CategoryName          $name,
        private readonly string       $slug,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable    $updatedAt,
    ) {}

    public static function reconstitute(
        int    $id,
        string $name,
        string $slug,
        string $createdAt,
        string $updatedAt,
    ): self {
        return new self(
            new CategoryId($id),
            new CategoryName($name),
            $slug,
            new \DateTimeImmutable($createdAt),
            new \DateTimeImmutable($updatedAt),
        );
    }

    public function id(): CategoryId              { return $this->id; }
    public function name(): CategoryName          { return $this->name; }
    public function slug(): string                { return $this->slug; }
    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }
}
