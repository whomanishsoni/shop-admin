<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = ['name', 'type', 'status'];

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
