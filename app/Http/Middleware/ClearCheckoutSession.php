<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class ClearCheckoutSession
{
    public function handle($request, Closure $next)
    {
        Session::forget(['order_id', 'checkout_address', 'checkout_address_ids']);
        return $next($request);
    }
}
