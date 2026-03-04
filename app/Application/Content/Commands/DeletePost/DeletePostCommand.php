<?php

namespace App\Application\Content\Commands\DeletePost;

final class DeletePostCommand
{
    public function __construct(
        public readonly int $id,
    ) {}
}
