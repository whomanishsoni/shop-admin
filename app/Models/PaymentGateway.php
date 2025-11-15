<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = ['name', 'gateway_key', 'mode', 'test_key_id', 'test_key_secret', 'live_key_id', 'live_key_secret', 'status'];
}
