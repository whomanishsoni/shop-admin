<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'customer_id',
        'name',
        'address',
        'city',
        'state',
        'pincode',
        'country',
        'is_default',
        'liked',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'liked' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
