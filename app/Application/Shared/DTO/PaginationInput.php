<?php

namespace App\Application\Shared\DTO;

final class PaginationInput
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $perPage = 15,
    ) {}
}
