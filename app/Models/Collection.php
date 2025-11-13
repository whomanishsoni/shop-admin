<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'sort_order',
        'status',
        'is_featured',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_collections');
    }
}
