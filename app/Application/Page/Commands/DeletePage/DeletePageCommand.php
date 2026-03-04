<?php

namespace App\Application\Page\Commands\DeletePage;

class DeletePageCommand
{
    public function __construct(public readonly int $id) {}
}
