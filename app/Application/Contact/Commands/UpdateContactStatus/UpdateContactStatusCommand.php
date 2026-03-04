<?php

namespace App\Application\Contact\Commands\UpdateContactStatus;

class UpdateContactStatusCommand
{
    public function __construct(
        public readonly int    $id,
        public readonly string $status,   // 'read' | 'replied'
    ) {}
}
