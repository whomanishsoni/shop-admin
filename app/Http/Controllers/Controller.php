<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ✅ LOGOUT PRESERVING CART & WISHLIST (Customer Only)
     */
    protected function logoutPreservingCart(Request $request)
    {
        Log::info('Logout preserving cart started', ['session_data' => session()->all()]);

        // 1. BACKUP cart & wishlist only if no recent order was completed
        $preservedData = [];
        if (!$request->session()->has('order_completed')) {
            $preservedData = [
                'cart' => $request->session()->get('cart', []),
                'wishlist' => $request->session()->get('wishlist', []),
            ];
        }
        Log::info('Preserved data', ['preserved_data' => $preservedData]);

        // 2. Log out CUSTOMER only
        \Auth::guard('customer')->logout();

        // 3. Invalidate auth session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 4. RESTORE cart & wishlist if preserved
        foreach ($preservedData as $key => $value) {
            $request->session()->put($key, $value);
        }
        Log::info('Session after logout', ['session_data' => session()->all()]);

        // 5. Clear order_completed flag
        $request->session()->forget('order_completed');
    }
}
