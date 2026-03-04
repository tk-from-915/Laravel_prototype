<?php

namespace App\Application\Page\Commands\CreatePage;

use App\Application\Page\Queries\GetPage\PageDTO;
use App\Domain\Page\Repositories\PageRepositoryInterface;

class CreatePageHandler
{
    public function __construct(private readonly PageRepositoryInterface $pages) {}

    public function handle(CreatePageCommand $command): PageDTO
    {
        if ($this->pages->findBySlug($command->slug) !== null) {
            throw new \DomainException("Slug already exists: {$command->slug}");
        }

        $page = $this->pages->create(
            slug:     $command->slug,
            title:    $command->title,
            body:     $command->body,
            status:   $command->status,
            authorId: $command->authorId,
        );

        return PageDTO::fromEntity($page);
    }
}
