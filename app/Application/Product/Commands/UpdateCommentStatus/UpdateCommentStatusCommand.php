<?php

namespace App\Application\Product\Commands\UpdateCommentStatus;

class UpdateCommentStatusCommand
{
    public function __construct(
        public readonly int    $id,
        public readonly string $status,
    ) {}
}
