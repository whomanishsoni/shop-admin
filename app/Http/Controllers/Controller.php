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
        // 1. BACKUP cart & wishlist
        $preservedData = [
            'cart' => $request->session()->get('cart', []),
            'wishlist' => $request->session()->get('wishlist', []),
        ];

        // 2. Log out CUSTOMER only
        \Auth::guard('customer')->logout();

        // 3. Invalidate auth session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 4. RESTORE cart & wishlist
        foreach ($preservedData as $key => $value) {
            $request->session()->put($key, $value);
        }
    }
}
