<?php

namespace App\Domain\Content\ValueObjects;

enum PostType: string
{
    case News = 'news';
    case Blog = 'blog';
}
