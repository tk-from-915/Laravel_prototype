<?php

namespace App\Domain\Contact\ValueObjects;

enum ContactStatus: string
{
    case Unread  = 'unread';
    case Read    = 'read';
    case Replied = 'replied';
}
