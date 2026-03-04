<?php

namespace App\Domain\User\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;

final class Email extends StringValueObject
{
    protected function validate(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format: {$value}");
        }
    }
}
