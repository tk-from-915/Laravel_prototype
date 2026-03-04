<?php

namespace App\Application\Page\Commands\UpdatePage;

class UpdatePageCommand
{
    public function __construct(
        public readonly int     $id,
        public readonly ?string $title,
        public readonly ?string $body,
        public readonly ?bool   $publish,   // true=公開, false=下書き, null=変更なし
    ) {}
}
