<?php

namespace App\Domain\Product\ValueObjects;

enum ProductStatus: string
{
    case Active   = 'active';
    case Inactive = 'inactive';
}
