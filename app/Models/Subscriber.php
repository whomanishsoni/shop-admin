<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['email', 'status', 'subscribed_at'];

    protected $casts = [
        'subscribed_at' => 'datetime',
    ];
}
