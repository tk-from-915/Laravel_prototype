<?php

namespace App\Application\Content\Commands\PublishPost;

final class PublishPostCommand
{
    public function __construct(
        public readonly int $id,
        public readonly bool $publish = true, // false = unpublish（下書きに戻す）
    ) {}
}
