<?php

namespace App\Domain\Content\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;

final class PostTitle extends StringValueObject
{
    protected function validate(string $value): void
    {
        $len = mb_strlen(trim($value));
        if ($len < 1 || $len > 255) {
            throw new \InvalidArgumentException('PostTitle must be between 1 and 255 characters.');
        }
    }
}
