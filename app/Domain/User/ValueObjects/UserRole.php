<?php

namespace App\Domain\User\ValueObjects;

enum UserRole: string
{
    case Admin  = 'admin';
    case Member = 'member';
}
