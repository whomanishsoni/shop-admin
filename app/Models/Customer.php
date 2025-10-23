<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'contact_no',
        'alternative_contact_no',
        'email_verified_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // This method is not used since we're handling the email in the controller
        // Leave it empty or implement only if needed
    }

    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }
}
