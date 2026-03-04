<?php

namespace App\Domain\Shared\ValueObjects;

abstract class IntId
{
    public function __construct(protected readonly int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException(
                sprintf('%s must be a positive integer, got %d.', static::class, $value)
            );
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(static $other): bool
    {
        return $this->value === $other->value;
    }
}
