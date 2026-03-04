<?php

namespace App\Application\Page\Queries\ListPages;

use App\Application\Page\Queries\GetPage\PageDTO;
use App\Domain\Page\Repositories\PageRepositoryInterface;

class ListPagesHandler
{
    public function __construct(private readonly PageRepositoryInterface $pages) {}

    public function handle(ListPagesQuery $query): array
    {
        $items = $this->pages->findAll(
            page:    $query->page,
            perPage: $query->perPage,
            status:  $query->status,
        );

        $total = $this->pages->countAll($query->status);

        return [
            'data'         => array_map(fn ($p) => PageDTO::fromEntity($p), $items),
            'total'        => $total,
            'per_page'     => $query->perPage,
            'current_page' => $query->page,
        ];
    }
}
