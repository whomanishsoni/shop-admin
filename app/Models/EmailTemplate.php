<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['name', 'subject', 'body', 'variables', 'status'];

    protected $casts = [
        'variables' => 'array',
    ];
}
