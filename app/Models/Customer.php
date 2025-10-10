<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Customer extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'contact_no',
        'alternative_contact_no',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function getNameAttribute()
    {
        return trim($this->first_name . ' ' . ($this->last_name ?? ''));
    }
}
