<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function __invoke()
    {
        $cartItems = []; // Placeholder for cart items
        return view('store.pages.cart', compact('cartItems'));
    }
}
