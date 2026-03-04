<?php

namespace App\Application\Page\Queries\GetPage;

use App\Domain\Page\Repositories\PageRepositoryInterface;
use App\Domain\Page\ValueObjects\PageId;

class GetPageHandler
{
    public function __construct(private readonly PageRepositoryInterface $pages) {}

    public function handle(GetPageQuery $query): ?PageDTO
    {
        $page = match (true) {
            $query->slug !== null => $this->pages->findBySlug($query->slug),
            $query->id   !== null => $this->pages->findById(new PageId($query->id)),
            default               => null,
        };

        return $page ? PageDTO::fromEntity($page) : null;
    }
}
