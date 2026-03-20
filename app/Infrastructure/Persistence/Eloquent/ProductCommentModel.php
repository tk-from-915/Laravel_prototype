<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Product\ValueObjects\CommentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCommentModel extends Model
{
    protected $table    = 'product_comments';
    protected $fillable = ['product_id', 'name', 'body', 'status'];

    protected $casts = [
        'status' => CommentStatus::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }
}
