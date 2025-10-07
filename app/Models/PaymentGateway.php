<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = ['name', 'gateway_key', 'api_key', 'api_secret', 'status', 'config'];

    protected $casts = [
        'config' => 'array',
    ];
}
