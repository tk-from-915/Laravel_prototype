<?php

namespace App\Domain\Content\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;

final class PostBody extends StringValueObject
{
    protected function validate(string $value): void
    {
        if (mb_strlen(trim($value)) < 1) {
            throw new \InvalidArgumentException('PostBody must not be empty.');
        }
    }
}
