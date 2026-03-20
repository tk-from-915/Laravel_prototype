<?php

namespace App\Domain\Product\ValueObjects;

class ProductCommentId
{
    public function __construct(private readonly int $value) {}

    public function value(): int { return $this->value; }
}
