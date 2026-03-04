<?php

namespace App\Domain\Product\ValueObjects;

class ProductPrice
{
    public function __construct(private readonly int $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('ProductPrice must be non-negative.');
        }
    }

    public function value(): int { return $this->value; }

    public function equals(self $other): bool { return $this->value === $other->value; }
}
