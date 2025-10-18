<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'image',
        'message',
        'rating',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'rating' => 'integer'
    ];
}
