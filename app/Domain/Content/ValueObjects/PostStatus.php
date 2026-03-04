<?php

namespace App\Domain\Content\ValueObjects;

enum PostStatus: string
{
    case Draft     = 'draft';
    case Published = 'published';
}
