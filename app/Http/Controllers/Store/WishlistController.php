<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function __invoke()
    {
        $wishlistItems = $this->getWishlistItems();
        return view('store.pages.account.wishlist', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,slug',
        ]);

        try {
            $product = Product::where('slug', $request->product_id)
                ->where('status', 'active')
                ->with(['images' => function ($query) {
                    $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
                }])
                ->firstOrFail();

            $wishlist = Session::get('wishlist', []);

            $wishlistItem = [
                'product_id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'image' => $product->images->first() ? asset('storage/' . $product->images->first()->image) : asset('assets/images/product/placeholder.jpg'),
                'stock' => $product->stock,
                'status' => $product->stock > 0 ? 'In-Stock' : 'Out Of Stock',
                'attributes' => [], // Initialize attributes
            ];

            // Handle product attributes (like size, color)
            foreach ($request->all() as $key => $value) {
                if (in_array($key, ['color', 'size']) && !empty($value)) {
                    $wishlistItem['attributes'][$key] = $value;
                }
            }

            $wishlistKey = $product->id . '-' . md5(json_encode($wishlistItem['attributes']));

            if (!isset($wishlist[$wishlistKey])) {
                $wishlist[$wishlistKey] = $wishlistItem;
                Session::put('wishlist', $wishlist);
            }

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Item added to wishlist successfully!'])
                : redirect()->route('wishlist')->with('success', 'Item added to wishlist successfully!');
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'An error occurred while adding the item to the wishlist.'], 500)
                : redirect()->back()->with('error', 'An error occurred while adding the item to the wishlist.');
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'wishlist_key' => 'required',
        ]);

        try {
            $wishlist = Session::get('wishlist', []);

            if (isset($wishlist[$request->wishlist_key])) {
                unset($wishlist[$request->wishlist_key]);
                Session::put('wishlist', $wishlist);

                return $request->wantsJson()
                    ? response()->json(['success' => true, 'message' => 'Item removed from wishlist successfully!'])
                    : redirect()->route('wishlist')->with('success', 'Item removed from wishlist successfully!');
            }

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Item not found in wishlist!'], 404)
                : redirect()->route('wishlist')->with('error', 'Item not found in wishlist!');
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'An error occurred while removing the item.'], 500)
                : redirect()->route('wishlist')->with('error', 'An error occurred while removing the item.');
        }
    }

    public function moveToCart(Request $request)
    {
        $request->validate([
            'wishlist_key' => 'required',
        ]);

        try {
            $wishlist = Session::get('wishlist', []);
            $cart = Session::get('cart', []);

            if (!isset($wishlist[$request->wishlist_key])) {
                return $request->wantsJson()
                    ? response()->json(['success' => false, 'message' => 'Item not found in wishlist!'], 404)
                    : redirect()->route('wishlist')->with('error', 'Item not found in wishlist!');
            }

            $item = $wishlist[$request->wishlist_key];
            $product = Product::find($item['product_id']);

            if (!$product || $product->status !== 'active') {
                return $request->wantsJson()
                    ? response()->json(['success' => false, 'message' => 'Product not available!'], 404)
                    : redirect()->route('wishlist')->with('error', 'Product not available!');
            }

            if ($product->stock < 1) {
                return $request->wantsJson()
                    ? response()->json(['success' => false, 'message' => 'Product is out of stock!'], 422)
                    : redirect()->route('wishlist')->with('error', 'Product is out of stock!');
            }

            $cartItem = [
                'product_id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'image' => $product->images->first() ? asset('storage/' . $product->images->first()->image) : asset('assets/images/product/placeholder.jpg'),
                'quantity' => 1, // Default quantity
                'attributes' => $item['attributes'],
            ];

            $cartKey = $product->id . '-' . md5(json_encode($cartItem['attributes']));

            if (isset($cart[$cartKey])) {
                $newQuantity = $cart[$cartKey]['quantity'] + 1;
                if ($newQuantity > $product->stock) {
                    return $request->wantsJson()
                        ? response()->json(['success' => false, 'message' => 'Quantity exceeds available stock of ' . $product->stock . '!'], 422)
                        : redirect()->route('wishlist')->with('error', 'Quantity exceeds available stock of ' . $product->stock . '!');
                }
                $cart[$cartKey]['quantity'] = $newQuantity;
            } else {
                $cart[$cartKey] = $cartItem;
            }

            // Remove from wishlist
            unset($wishlist[$request->wishlist_key]);
            Session::put('wishlist', $wishlist);
            Session::put('cart', $cart);

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Item moved to cart successfully!'])
                : redirect()->route('wishlist')->with('success', 'Item moved to cart successfully!');
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'An error occurred while moving the item to the cart.'], 500)
                : redirect()->route('wishlist')->with('error', 'An error occurred while moving the item to the cart.');
        }
    }

    private function getWishlistItems()
    {
        $wishlist = Session::get('wishlist', []);
        return array_map(function ($item) {
            $item['attributes'] = isset($item['attributes']) ? $item['attributes'] : [];
            return $item;
        }, $wishlist);
    }
}
