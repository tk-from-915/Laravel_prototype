<?php

namespace App\Domain\Page\ValueObjects;

enum PageStatus: string
{
    case Draft     = 'draft';
    case Published = 'published';
}
