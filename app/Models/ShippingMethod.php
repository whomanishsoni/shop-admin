<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = ['name', 'description', 'cost', 'delivery_time', 'status'];

    public function shippingZones()
    {
        return $this->hasMany(ShippingZone::class);
    }
}
