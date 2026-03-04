<?php

namespace App\Domain\Product\Entities;

use App\Domain\Product\ValueObjects\ProductId;
use App\Domain\Product\ValueObjects\ProductName;
use App\Domain\Product\ValueObjects\ProductDescription;
use App\Domain\Product\ValueObjects\ProductPrice;
use App\Domain\Product\ValueObjects\ProductStatus;
use App\Domain\Product\ValueObjects\CategoryId;
use App\Domain\User\ValueObjects\UserId;

class Product
{
    private function __construct(
        private readonly ProductId          $id,
        private ProductName                 $name,
        private ?ProductDescription         $description,
        private ProductPrice                $price,
        private ProductStatus               $status,
        private readonly UserId             $authorId,
        /** @var CategoryId[] */
        private array                       $categoryIds,
        private readonly \DateTimeImmutable $createdAt,
        private \DateTimeImmutable          $updatedAt,
    ) {}

    public static function reconstitute(
        int     $id,
        string  $name,
        ?string $description,
        int     $price,
        string  $status,
        int     $authorId,
        array   $categoryIds,
        string  $createdAt,
        string  $updatedAt,
    ): self {
        return new self(
            new ProductId($id),
            new ProductName($name),
            $description !== null ? new ProductDescription($description) : null,
            new ProductPrice($price),
            ProductStatus::from($status),
            new UserId($authorId),
            array_map(fn (int $cid) => new CategoryId($cid), $categoryIds),
            new \DateTimeImmutable($createdAt),
            new \DateTimeImmutable($updatedAt),
        );
    }

    public function update(?string $name, ?string $description, ?int $price): void
    {
        if ($name !== null)        { $this->name        = new ProductName($name); }
        if ($description !== null) { $this->description = new ProductDescription($description); }
        if ($price !== null)       { $this->price       = new ProductPrice($price); }
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function changeStatus(ProductStatus $status): void
    {
        $this->status    = $status;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function syncCategories(array $categoryIds): void
    {
        $this->categoryIds = array_map(fn (int $cid) => new CategoryId($cid), $categoryIds);
        $this->updatedAt   = new \DateTimeImmutable();
    }

    public function id(): ProductId                { return $this->id; }
    public function name(): ProductName            { return $this->name; }
    public function description(): ?ProductDescription { return $this->description; }
    public function price(): ProductPrice          { return $this->price; }
    public function status(): ProductStatus        { return $this->status; }
    public function authorId(): UserId             { return $this->authorId; }
    /** @return CategoryId[] */
    public function categoryIds(): array           { return $this->categoryIds; }
    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }
}
