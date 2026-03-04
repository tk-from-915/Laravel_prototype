<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Content\ValueObjects\PostStatus;
use App\Domain\Content\ValueObjects\PostType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostModel extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'type',
        'title',
        'body',
        'status',
        'author_id',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'type'         => PostType::class,
            'status'       => PostStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'author_id');
    }
}
