<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Product\ValueObjects\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductModel extends Model
{
    protected $table    = 'products';
    protected $fillable = ['name', 'description', 'price', 'status', 'author_id'];

    protected $casts = [
        'status' => ProductStatus::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CategoryModel::class, 'category_product', 'product_id', 'category_id');
    }
}
