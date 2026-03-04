<?php

namespace App\Domain\User\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;

final class UserName extends StringValueObject
{
    protected function validate(string $value): void
    {
        $len = mb_strlen(trim($value));
        if ($len < 1 || $len > 100) {
            throw new \InvalidArgumentException('UserName must be between 1 and 100 characters.');
        }
    }
}
