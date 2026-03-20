<?php

namespace App\Application\Product\Commands\DeleteComment;

class DeleteCommentCommand
{
    public function __construct(public readonly int $id) {}
}
