<?php

namespace App\Application\Page\Commands\DeletePage;

use App\Domain\Page\Repositories\PageRepositoryInterface;
use App\Domain\Page\ValueObjects\PageId;

class DeletePageHandler
{
    public function __construct(private readonly PageRepositoryInterface $pages) {}

    public function handle(DeletePageCommand $command): bool
    {
        $page = $this->pages->findById(new PageId($command->id))
            ?? throw new \DomainException("Page not found: {$command->id}");

        $this->pages->delete($page->id());

        return true;
    }
}
