<?php

namespace App\Application\User\Queries\GetUser;

final class GetUserQuery
{
    public function __construct(
        public readonly int $id,
    ) {}
}
