<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __invoke()
    {
        $wishlist = [
            [
                'id' => 1,
                'slug' => 'printed-kurta-with-pant-dupatta',
                'name' => 'Printed Kurta with Pant & Dupatta',
                'image' => 'assets/images/product/p7.jpg',
                'color' => 'Yellow',
                'size' => 'L',
                'weight' => null,
                'price' => 1200.00,
                'status' => 'In-Stock',
                'liked' => false,
            ],
            [
                'id' => 2,
                'slug' => 'womens-rayon-viscose-anarkali-printed-kurta',
                'name' => 'Women\'s Rayon Viscose Anarkali Printed Kurta',
                'image' => 'assets/images/product/p16.jpg',
                'color' => 'Pink',
                'size' => null,
                'weight' => '1.5 Kg',
                'price' => 1500.00,
                'status' => 'Out Of Stock',
                'liked' => true,
            ],
        ];

        return view('store.pages.account.wishlist', compact('wishlist'));
    }

    public function add(Request $request)
    {
        // Placeholder for adding to wishlist (static response for now)
        return redirect()->route('wishlist')->with('success', 'Item added to wishlist.');
    }

    public function remove(Request $request, $id)
    {
        // Placeholder for removing from wishlist (static response for now)
        return redirect()->route('wishlist')->with('success', 'Item removed from wishlist.');
    }
}
