<?php

namespace App\Domain\Shared\ValueObjects;

abstract class StringValueObject
{
    public function __construct(protected readonly string $value)
    {
        $this->validate($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    protected function validate(string $value): void {}
}
