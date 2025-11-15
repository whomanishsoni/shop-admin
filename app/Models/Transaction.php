<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'order_id', 'transaction_id', 'gateway_order_id', 'gateway_transaction_id', 'amount', 'currency',
        'payment_method', 'payment_mode', 'bank_name', 'card_type', 'card_network', 'wallet_name', 'vpa',
        'status', 'payment_date', 'gateway_response', 'payment_response', 'payment_gateway', 'fee', 'tax',
        'acquirer_data', 'error_code', 'error_description'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
