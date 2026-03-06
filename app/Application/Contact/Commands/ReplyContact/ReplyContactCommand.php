<?php

namespace App\Application\Contact\Commands\ReplyContact;

final class ReplyContactCommand
{
    public function __construct(
        public readonly int    $id,
        public readonly string $subject,
        public readonly string $message,
    ) {}
}
