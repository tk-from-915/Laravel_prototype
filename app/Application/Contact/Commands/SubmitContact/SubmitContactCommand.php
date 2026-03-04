<?php

namespace App\Application\Contact\Commands\SubmitContact;

class SubmitContactCommand
{
    public function __construct(
        public readonly string  $name,
        public readonly ?string $tel,
        public readonly string  $email,
        public readonly string  $type,
        public readonly string  $message,
    ) {}
}
