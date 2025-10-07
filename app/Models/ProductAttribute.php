<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = ['name', 'display_name', 'values', 'status'];

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
