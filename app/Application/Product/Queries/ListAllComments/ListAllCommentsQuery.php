<?php

namespace App\Application\Product\Queries\ListAllComments;

class ListAllCommentsQuery
{
    public function __construct(public readonly ?string $status = null) {}
}
