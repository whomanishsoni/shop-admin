<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image', 'alt_text', 'sort_order', 'is_primary'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
