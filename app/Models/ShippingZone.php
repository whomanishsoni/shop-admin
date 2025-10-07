<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = ['name', 'states', 'shipping_method_id', 'rate', 'status'];

    protected $casts = [
        'states' => 'array',
    ];

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }
}
