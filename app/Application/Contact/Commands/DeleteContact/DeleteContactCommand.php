<?php

namespace App\Application\Contact\Commands\DeleteContact;

class DeleteContactCommand
{
    public function __construct(public readonly int $id) {}
}
