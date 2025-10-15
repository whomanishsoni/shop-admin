<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __invoke()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $this->calculateSubtotal($cartItems);
        $taxRate = 0.18; // 18% tax rate
        $tax = $subtotal * $taxRate;
        $shipping = 0.00; // You can implement dynamic shipping later
        $grandTotal = $subtotal + $tax + $shipping;

        return view('store.pages.cart', compact('cartItems', 'subtotal', 'tax', 'shipping', 'grandTotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,slug',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $product = Product::where('slug', $request->product_id)
                ->where('status', 'active')
                ->with(['images' => function ($query) {
                    $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
                }])
                ->firstOrFail();

            if ($request->quantity > $product->stock) {
                return $request->wantsJson()
                    ? response()->json(['success' => false, 'message' => 'Quantity exceeds available stock of ' . $product->stock . '!'])
                    : redirect()->back()->with('error', 'Quantity exceeds available stock of ' . $product->stock . '!');
            }

            $cart = Session::get('cart', []);

            $cartItem = [
                'product_id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'image' => $product->images->first() ? asset('storage/' . $product->images->first()->image) : asset('assets/images/product/placeholder.jpg'),
                'quantity' => $request->quantity,
                'attributes' => [], // Ensure attributes is always initialized
            ];

            // Handle product attributes (like size, color)
            foreach ($request->all() as $key => $value) {
                if (in_array($key, ['color', 'size']) && !empty($value)) {
                    $cartItem['attributes'][$key] = $value;
                }
            }

            $cartKey = $product->id . '-' . md5(json_encode($cartItem['attributes']));

            if (isset($cart[$cartKey])) {
                $newQuantity = $cart[$cartKey]['quantity'] + $request->quantity;
                if ($newQuantity > $product->stock) {
                    return $request->wantsJson()
                        ? response()->json(['success' => false, 'message' => 'Quantity exceeds available stock of ' . $product->stock . '!'])
                        : redirect()->back()->with('error', 'Quantity exceeds available stock of ' . $product->stock . '!');
                }
                $cart[$cartKey]['quantity'] = $newQuantity;
            } else {
                $cart[$cartKey] = $cartItem;
            }

            Session::put('cart', $cart);

            if ($request->has('buy_now')) {
                return redirect()->route('checkout');
            }

            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => 'Product added to cart successfully!'])
                : redirect()->route('cart')->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'An error occurred while adding the item.'], 500)
                : redirect()->back()->with('error', 'An error occurred while adding the item.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cart = Session::get('cart', []);

            if (isset($cart[$request->cart_key])) {
                $item = $cart[$request->cart_key];
                $product = Product::find($item['product_id']);

                if (!$product) {
                    return $request->wantsJson()
                        ? response()->json(['success' => false, 'message' => 'Product not found!'], 404)
                        : redirect()->route('cart')->with('error', 'Product not found!');
                }

                if ($request->quantity > $product->stock) {
                    return $request->wantsJson()
                        ? response()->json([
                            'success' => false,
                            'message' => 'Quantity exceeds available stock of ' . $product->stock . '!',
                            'oldQuantity' => $item['quantity']
                        ], 422)
                        : redirect()->route('cart')->with('error', 'Quantity exceeds available stock of ' . $product->stock . '!');
                }

                $cart[$request->cart_key]['quantity'] = $request->quantity;
                Session::put('cart', $cart);

                if ($request->wantsJson()) {
                    $cartItems = $this->getCartItems();
                    $subtotal = $this->calculateSubtotal($cartItems);
                    $tax = $subtotal * 0.18;
                    $shipping = 0.00;
                    $grandTotal = $subtotal + $tax + $shipping;
                    $itemTotal = $item['price'] * $request->quantity;

                    return response()->json([
                        'success' => true,
                        'message' => 'Cart updated successfully!',
                        'subtotal' => number_format($subtotal, 2, '.', ''),
                        'tax' => number_format($tax, 2, '.', ''),
                        'shipping' => number_format($shipping, 2, '.', ''),
                        'grandTotal' => number_format($grandTotal, 2, '.', ''),
                        'itemTotal' => number_format($itemTotal, 2, '.', '')
                    ]);
                }

                return redirect()->route('cart')->with('success', 'Cart updated successfully!');
            }

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Item not found in cart!'], 404)
                : redirect()->route('cart')->with('error', 'Item not found in cart!');
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'An error occurred while updating the cart.'], 500)
                : redirect()->route('cart')->with('error', 'An error occurred while updating the cart.');
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_key' => 'required',
        ]);

        try {
            $cart = Session::get('cart', []);

            if (isset($cart[$request->cart_key])) {
                unset($cart[$request->cart_key]);
                Session::put('cart', $cart);

                if ($request->wantsJson()) {
                    $cartItems = $this->getCartItems();
                    $subtotal = $this->calculateSubtotal($cartItems);
                    $tax = $subtotal * 0.18;
                    $shipping = 0.00;
                    $grandTotal = $subtotal + $tax + $shipping;

                    return response()->json([
                        'success' => true,
                        'message' => 'Item removed from cart successfully!',
                        'subtotal' => number_format($subtotal, 2, '.', ''),
                        'tax' => number_format($tax, 2, '.', ''),
                        'shipping' => number_format($shipping, 2, '.', ''),
                        'grandTotal' => number_format($grandTotal, 2, '.', '')
                    ]);
                }

                return redirect()->route('cart')->with('success', 'Item removed from cart successfully!');
            }

            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Item not found in cart!'], 404)
                : redirect()->route('cart')->with('error', 'Item not found in cart!');
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'An error occurred while removing the item.'], 500)
                : redirect()->route('cart')->with('error', 'An error occurred while removing the item.');
        }
    }

    public function clear(Request $request)
    {
        try {
            Session::forget('cart');

            return $request->wantsJson()
                ? response()->json([
                    'success' => true,
                    'message' => 'Cart cleared successfully!',
                    'subtotal' => '0.00',
                    'tax' => '0.00',
                    'shipping' => '0.00',
                    'grandTotal' => '0.00'
                ])
                : redirect()->route('cart')->with('success', 'Cart cleared successfully!');
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'An error occurred while clearing the cart.'], 500)
                : redirect()->route('cart')->with('error', 'An error occurred while clearing the cart.');
        }
    }

    public function getCartItems()
    {
        $cart = Session::get('cart', []);
        return array_map(function ($item) {
            $item['attributes'] = isset($item['attributes']) ? $item['attributes'] : [];
            $item['total'] = $item['price'] * $item['quantity'];
            return $item;
        }, $cart);
    }

    public function calculateSubtotal($cartItems = null)
    {
        if ($cartItems === null) {
            $cartItems = $this->getCartItems();
        }
        return array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cartItems));
    }
}
