<?php

namespace App\Application\Page\Commands\UpdatePage;

use App\Application\Page\Queries\GetPage\PageDTO;
use App\Domain\Page\Repositories\PageRepositoryInterface;
use App\Domain\Page\ValueObjects\PageId;

class UpdatePageHandler
{
    public function __construct(private readonly PageRepositoryInterface $pages) {}

    public function handle(UpdatePageCommand $command): PageDTO
    {
        $page = $this->pages->findById(new PageId($command->id))
            ?? throw new \DomainException("Page not found: {$command->id}");

        $page->update($command->title, $command->body);

        if ($command->publish === true)  { $page->publish(); }
        if ($command->publish === false) { $page->unpublish(); }

        $saved = $this->pages->update($page);

        return PageDTO::fromEntity($saved);
    }
}
