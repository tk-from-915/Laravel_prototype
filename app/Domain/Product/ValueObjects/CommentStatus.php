<?php

namespace App\Domain\Product\ValueObjects;

enum CommentStatus: string
{
    case Pending  = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
