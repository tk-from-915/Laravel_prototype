<?php

namespace App\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $fillable   = ['slug', 'name'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductModel::class, 'category_product', 'category_id', 'product_id');
    }
}
