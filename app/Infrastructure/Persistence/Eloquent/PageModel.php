<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Page\ValueObjects\PageStatus;
use Illuminate\Database\Eloquent\Model;

class PageModel extends Model
{
    protected $table    = 'pages';
    protected $fillable = ['slug', 'title', 'body', 'status', 'author_id'];

    protected $casts = [
        'status' => PageStatus::class,
    ];
}
