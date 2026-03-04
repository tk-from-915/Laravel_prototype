<?php

namespace App\Domain\Product\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;

class ProductName extends StringValueObject
{
    protected function validate(string $value): void
    {
        if (mb_strlen($value) === 0 || mb_strlen($value) > 255) {
            throw new \InvalidArgumentException('ProductName must be between 1 and 255 characters.');
        }
    }
}
