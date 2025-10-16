<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\{Customer, Order, OrderItem, Address, Coupon, PaymentGateway};
use App\Http\Controllers\Store\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }

        $cartItems = app(CartController::class)->getCartItems();
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = app(CartController::class)->calculateSubtotal($cartItems);
        $taxRate = 0.18;
        $tax = $subtotal * $taxRate;
        $shipping = 0.00;
        $couponDiscount = 0.00;
        $couponCode = Session::get('coupon_code', '');

        if ($couponCode) {
            $coupon = Coupon::where('code', strtoupper($couponCode))
                ->where('status', 1)
                ->where(function ($query) {
                    $query->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('valid_to')->orWhere('valid_to', '>=', now());
                })
                ->first();

            if ($coupon && $subtotal >= ($coupon->min_purchase ?? 0)) {
                if ($coupon->type == 'percentage') {
                    $couponDiscount = $subtotal * ($coupon->value / 100);
                } else {
                    $couponDiscount = $coupon->value;
                }
            } else {
                Session::forget('coupon_code');
                $couponCode = '';
            }
        }

        $grandTotal = $subtotal + $tax + $shipping - $couponDiscount;

        $defaultAddress = $customer->addresses()->where('is_default', true)->first();

        $cartSummary = [
            'items' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'couponDiscount' => $couponDiscount,
            'couponCode' => $couponCode,
            'grandTotal' => $grandTotal,
            'defaultAddress' => $defaultAddress,
        ];

        return view('store.pages.checkout', compact('cartSummary'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string|max:50']);

        $couponCode = strtoupper($request->coupon_code);
        $cartItems = app(CartController::class)->getCartItems();
        $subtotal = app(CartController::class)->calculateSubtotal($cartItems);
        $taxRate = 0.18;
        $tax = $subtotal * $taxRate;
        $shipping = 0.00;

        $coupon = Coupon::where('code', $couponCode)
            ->where('status', 1)
            ->where(function ($query) {
                $query->whereNull('valid_from')->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_to')->orWhere('valid_to', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ]);
        }

        if ($subtotal < ($coupon->min_purchase ?? 0)) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum purchase requirement not met'
            ]);
        }

        $discountAmount = $this->calculateDiscount($coupon, $subtotal);
        $grandTotal = $subtotal + $tax + $shipping - $discountAmount;

        Session::put('coupon_code', $couponCode);
        Session::put('coupon_discount', $discountAmount);

        return response()->json([
            'success' => true,
            'discount_amount' => number_format($discountAmount, 2),
            'subtotal' => number_format($subtotal, 2),
            'tax' => number_format($tax, 2),
            'shipping' => number_format($shipping, 2),
            'total' => number_format($grandTotal, 2),
            'message' => "Coupon <strong>$couponCode</strong> applied successfully!"
        ]);
    }

    public function removeCoupon()
    {
        $cartItems = app(CartController::class)->getCartItems();
        $subtotal = app(CartController::class)->calculateSubtotal($cartItems);
        $taxRate = 0.18;
        $tax = $subtotal * $taxRate;
        $shipping = 0.00;
        $grandTotal = $subtotal + $tax + $shipping;

        Session::forget('coupon_code');
        Session::forget('coupon_discount');

        return response()->json([
            'success' => true,
            'updated_totals' => [
                'subtotal' => number_format($subtotal, 2),
                'tax' => number_format($tax, 2),
                'shipping' => number_format($shipping, 2),
                'discount_amount' => '0.00',
                'total' => number_format($grandTotal, 2)
            ],
            'message' => 'Coupon removed successfully'
        ]);
    }

    private function calculateDiscount($coupon, $subtotal)
    {
        if ($coupon->type === 'percentage') {
            return ($subtotal * $coupon->value) / 100;
        } else {
            return min($coupon->value, $subtotal);
        }
    }

    // private function addressExists($customerId, $addressData)
    // {
    //     return Address::where('customer_id', $customerId)
    //         ->where('name', $addressData['name'])
    //         ->where('address', $addressData['address'])
    //         ->where('city', $addressData['city'])
    //         ->where('pincode', $addressData['pincode'])
    //         ->where('country', $addressData['country'])
    //         ->exists();
    // }

    // public function saveAddress(Request $request)
    // {
    //     Log::info('Save address method started', ['request' => $request->all()]);

    //     $rules = [
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'address1' => 'required|string|max:500',
    //         'city' => 'required|string|max:100',
    //         'postal_code' => 'required|string|max:20',
    //         'country' => 'required|string|max:100',
    //         'checkmethod' => 'required|in:same,different',
    //     ];

    //     $request->validate($rules);
    //     Log::info('Validation passed', ['rules' => $rules]);

    //     $customer = Auth::guard('customer')->user();
    //     if (!$customer) {
    //         Log::warning('No authenticated customer');
    //         return redirect()->route('login')->with('error', 'Please login to checkout.');
    //     }
    //     Log::info('Customer authenticated', ['customer_id' => $customer->id]);

    //     $cartItems = app(CartController::class)->getCartItems();
    //     if (empty($cartItems)) {
    //         Log::warning('Cart is empty');
    //         return redirect()->route('cart')->with('error', 'Your cart is empty.');
    //     }
    //     Log::info('Cart items retrieved', ['item_count' => count($cartItems)]);

    //     $shippingName = $request->first_name . ' ' . $request->last_name;
    //     $shippingAddress = $request->address1 . ($request->address2 ? ' ' . $request->address2 : '');

    //     $addressData = [
    //         'shipping' => [
    //             'name' => $shippingName,
    //             'address' => $shippingAddress,
    //             'city' => $request->city,
    //             'state' => '',
    //             'pincode' => $request->postal_code,
    //             'country' => $request->country,
    //         ]
    //     ];

    //     if ($request->checkmethod === 'same') {
    //         $addressData['billing'] = $addressData['shipping'];
    //     } else {
    //         $defaultAddress = $customer->addresses()->where('is_default', true)->first();
    //         $addressData['billing'] = $defaultAddress ? [
    //             'name' => $defaultAddress->name,
    //             'address' => $defaultAddress->address,
    //             'city' => $defaultAddress->city,
    //             'state' => $defaultAddress->state ?? '',
    //             'pincode' => $defaultAddress->pincode,
    //             'country' => $defaultAddress->country ?? 'India',
    //         ] : $addressData['shipping'];
    //     }

    //     DB::beginTransaction();
    //     try {
    //         // Check if shipping address already exists
    //         if (!$this->addressExists($customer->id, $addressData['shipping'])) {
    //             $isDefault = !$customer->addresses()->where('is_default', true)->exists();
    //             Address::create([
    //                 'customer_id' => $customer->id,
    //                 'name' => $addressData['shipping']['name'],
    //                 'address' => $addressData['shipping']['address'],
    //                 'city' => $addressData['shipping']['city'],
    //                 'state' => $addressData['shipping']['state'],
    //                 'pincode' => $addressData['shipping']['pincode'],
    //                 'country' => $addressData['shipping']['country'],
    //                 'phone' => $customer->contact_no,
    //                 'email' => $customer->email,
    //                 'is_default' => $isDefault,
    //             ]);
    //             Log::info('New shipping address created', ['customer_id' => $customer->id]);
    //         } else {
    //             Log::info('Shipping address already exists, skipping creation', ['customer_id' => $customer->id]);
    //         }

    //         // Only create a separate billing address if it differs and a default already exists
    //         if ($request->checkmethod === 'different' && !$this->addressExists($customer->id, $addressData['billing'])) {
    //             Address::create([
    //                 'customer_id' => $customer->id,
    //                 'name' => $addressData['billing']['name'],
    //                 'address' => $addressData['billing']['address'],
    //                 'city' => $addressData['billing']['city'],
    //                 'state' => $addressData['billing']['state'],
    //                 'pincode' => $addressData['billing']['pincode'],
    //                 'country' => $addressData['billing']['country'],
    //                 'phone' => $customer->contact_no,
    //                 'email' => $customer->email,
    //                 'is_default' => false,
    //             ]);
    //             Log::info('New billing address created', ['customer_id' => $customer->id]);
    //         } else {
    //             Log::info('Billing address already exists or same as shipping, skipping creation', ['customer_id' => $customer->id]);
    //         }

    //         DB::commit();
    //         Log::info('Addresses saved to database', ['customer_id' => $customer->id]);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Log::error('Failed to save addresses', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    //         return redirect()->route('checkout')->with('error', 'Failed to save address. Please try again.');
    //     }

    //     // Store address data in session for display purposes
    //     Session::put('checkout_address', $addressData);
    //     Log::info('Address data saved to session', ['address_data' => $addressData]);

    //     return redirect()->route('checkout')->with('success', 'Address saved successfully. Proceed to payment.');
    // }

    // public function createOrderAndPayment(Request $request)
    // {
    //     Log::info('Create order and payment method started', ['request' => $request->all(), 'session_order_id' => session('order_id')]);

    //     $customer = Auth::guard('customer')->user();
    //     if (!$customer) {
    //         Log::warning('No authenticated customer');
    //         return redirect()->route('login')->with('error', 'Please login to checkout.');
    //     }

    //     $cartItems = app(CartController::class)->getCartItems();
    //     if (empty($cartItems)) {
    //         Log::warning('Cart is empty');
    //         return redirect()->route('cart')->with('error', 'Your cart is empty.');
    //     }

    //     // Fetch the latest address from the database
    //     $latestAddress = $customer->addresses()->orderBy('created_at', 'desc')->first();
    //     $defaultAddress = $customer->addresses()->where('is_default', true)->first() ?? $latestAddress;

    //     if (!$latestAddress) {
    //         Log::warning('No address found', ['session' => session()->all()]);
    //         return redirect()->route('checkout')->with('error', 'Please provide an address.');
    //     }

    //     $addressData = [
    //         'shipping' => [
    //             'name' => $latestAddress->name,
    //             'address' => $latestAddress->address,
    //             'city' => $latestAddress->city,
    //             'state' => $latestAddress->state ?? '',
    //             'pincode' => $latestAddress->pincode,
    //             'country' => $latestAddress->country,
    //         ],
    //         'billing' => [
    //             'name' => $defaultAddress->name,
    //             'address' => $defaultAddress->address,
    //             'city' => $defaultAddress->city,
    //             'state' => $defaultAddress->state ?? '',
    //             'pincode' => $defaultAddress->pincode,
    //             'country' => $defaultAddress->country,
    //         ]
    //     ];

    //     DB::beginTransaction();
    //     Log::info('Transaction started');

    //     try {
    //         $subtotal = app(CartController::class)->calculateSubtotal($cartItems);
    //         $tax = $subtotal * 0.18;
    //         $shipping = 0.00;
    //         $couponCode = Session::get('coupon_code', '');
    //         $couponDiscount = 0.00;
    //         $coupon = null;

    //         if ($couponCode) {
    //             $coupon = Coupon::where('code', strtoupper($couponCode))->first();
    //             if ($coupon) {
    //                 if ($coupon->type == 'percentage') {
    //                     $couponDiscount = $subtotal * ($coupon->value / 100);
    //                 } else {
    //                     $couponDiscount = $coupon->value;
    //                 }
    //             }
    //         }
    //         Log::info('Order totals calculated', [
    //             'subtotal' => $subtotal,
    //             'tax' => $tax,
    //             'shipping' => $shipping,
    //             'coupon_discount' => $couponDiscount
    //         ]);

    //         $grandTotal = $subtotal + $tax + $shipping - $couponDiscount;

    //         $order = Order::create([
    //             'customer_id' => $customer->id,
    //             'order_number' => 'ORD-' . Str::upper(Str::random(8)),
    //             'subtotal' => $subtotal,
    //             'tax' => $tax,
    //             'shipping' => $shipping,
    //             'coupon_code' => $couponCode,
    //             'discount' => $couponDiscount,
    //             'total' => $grandTotal,
    //             'status' => 'pending',
    //             'payment_status' => 'pending',
    //             'payment_method' => null,
    //             'shipping_address' => $addressData['shipping']['address'] . ', ' . $addressData['shipping']['city'] . ', ' . $addressData['shipping']['pincode'] . ', ' . $addressData['shipping']['country'],
    //             'billing_address' => $addressData['billing']['address'] . ', ' . $addressData['billing']['city'] . ', ' . $addressData['billing']['pincode'] . ', ' . $addressData['billing']['country'],
    //         ]);
    //         Log::info('Order created', ['order_id' => $order->id]);

    //         foreach ($cartItems as $cartKey => $item) {
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $item['product_id'],
    //                 'name' => $item['name'],
    //                 'price' => $item['price'],
    //                 'quantity' => $item['quantity'],
    //                 'attributes' => json_encode($item['attributes'] ?? []),
    //             ]);
    //         }
    //         Log::info('Order items created', ['order_id' => $order->id, 'item_count' => count($cartItems)]);

    //         DB::commit();
    //         Log::info('Transaction committed');

    //         if ($coupon && $coupon->usage_limit) {
    //             $coupon->increment('used');
    //             if ($coupon->fresh()->used >= $coupon->usage_limit) {
    //                 $coupon->update(['status' => 0]);
    //             }
    //         }
    //         Log::info('Coupon usage updated', ['coupon_code' => $couponCode]);

    //         session(['order_id' => $order->id]);
    //         Log::info('Session updated with order_id', ['order_id' => $order->id, 'session_data' => session()->all()]);

    //         return redirect()->route('checkout.payment', $order->id)->with('success', 'Proceed to payment.');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Log::error('Order creation failed', [
    //             'error' => $e->getMessage(),
    //             'session' => session()->all(),
    //             'request' => $request->all(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         return redirect()->route('checkout')->with('error', 'Something went wrong during order creation!');
    //     }
    // }

    public function createOrderAndPayment(Request $request)
    {
        Log::info('Create order and payment method started', [
            'request' => $request->all(),
            'session_order_id' => session('order_id'),
            'session_cart_hash' => session('cart_hash'),
            'session_data' => session()->all()
        ]);

        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            Log::warning('No authenticated customer');
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }

        $cartItems = app(CartController::class)->getCartItems();
        if (empty($cartItems)) {
            Log::warning('Cart is empty');
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Fetch the latest address and default address
        $latestAddress = $customer->addresses()->orderBy('created_at', 'desc')->first();
        $defaultAddress = $customer->addresses()->where('is_default', true)->first() ?? $latestAddress;

        if (!$latestAddress) {
            Log::warning('No address found', ['session' => session()->all()]);
            return redirect()->route('checkout')->with('error', 'Please provide an address.');
        }

        $addressData = [
            'shipping' => [
                'name' => $latestAddress->name,
                'address' => $latestAddress->address,
                'city' => $latestAddress->city,
                'state' => $latestAddress->state ?? '',
                'pincode' => $latestAddress->pincode,
                'country' => $latestAddress->country,
            ],
            'billing' => [
                'name' => $defaultAddress->name,
                'address' => $defaultAddress->address,
                'city' => $defaultAddress->city,
                'state' => $defaultAddress->state ?? '',
                'pincode' => $defaultAddress->pincode,
                'country' => $defaultAddress->country,
            ]
        ];

        // Generate a hash of the current cart items
        $currentCartHash = md5(json_encode($cartItems));
        Log::info('Current cart hash generated', ['cart_hash' => $currentCartHash]);

        // Check for existing pending order in session
        $existingOrderId = session('order_id');
        if ($existingOrderId) {
            $existingOrder = Order::where('id', $existingOrderId)
                ->where('customer_id', $customer->id)
                ->where('status', 'pending')
                ->where('payment_status', 'pending')
                ->first();

            if ($existingOrder) {
                // Compare cart_hash from session to ensure cart is unchanged
                $sessionCartHash = session('cart_hash');
                Log::info('Checking existing order', [
                    'order_id' => $existingOrderId,
                    'session_cart_hash' => $sessionCartHash,
                    'current_cart_hash' => $currentCartHash,
                    'existing_subtotal' => $existingOrder->subtotal,
                    'current_subtotal' => app(CartController::class)->calculateSubtotal($cartItems),
                    'existing_item_count' => $existingOrder->items()->count(),
                    'current_item_count' => count($cartItems)
                ]);

                if ($sessionCartHash === $currentCartHash) {
                    Log::info('Existing pending order found and matches current cart, reusing order', [
                        'order_id' => $existingOrderId
                    ]);
                    return redirect()->route('checkout.payment', $existingOrderId)->with('success', 'Proceed to payment.');
                } else {
                    Log::info('Existing order found but cart has changed, cancelling old order', [
                        'order_id' => $existingOrderId,
                        'session_cart_hash' => $sessionCartHash,
                        'current_cart_hash' => $currentCartHash
                    ]);
                    $existingOrder->update(['status' => 'cancelled']);
                    Session::forget('order_id'); // Clear old order_id
                }
            } else {
                Log::info('No valid existing order found for order_id', ['order_id' => $existingOrderId]);
                Session::forget('order_id'); // Clear invalid order_id
            }
        }

        DB::beginTransaction();
        Log::info('Transaction started');

        try {
            $subtotal = app(CartController::class)->calculateSubtotal($cartItems);
            $tax = $subtotal * 0.18;
            $shipping = 0.00;
            $couponCode = Session::get('coupon_code', '');
            $couponDiscount = 0.00;
            $coupon = null;

            if ($couponCode) {
                $coupon = Coupon::where('code', strtoupper($couponCode))->first();
                if ($coupon) {
                    if ($coupon->type == 'percentage') {
                        $couponDiscount = $subtotal * ($coupon->value / 100);
                    } else {
                        $couponDiscount = $coupon->value;
                    }
                }
            }
            Log::info('Order totals calculated', [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'coupon_discount' => $couponDiscount
            ]);

            $grandTotal = $subtotal + $tax + $shipping - $couponDiscount;

            $order = Order::create([
                'customer_id' => $customer->id,
                'order_number' => 'ORD-' . Str::upper(Str::random(8)),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'coupon_code' => $couponCode,
                'discount' => $couponDiscount,
                'total' => $grandTotal,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => null,
                'shipping_address' => $addressData['shipping']['address'] . ', ' . $addressData['shipping']['city'] . ', ' . $addressData['shipping']['pincode'] . ', ' . $addressData['shipping']['country'],
                'billing_address' => $addressData['billing']['address'] . ', ' . $addressData['billing']['city'] . ', ' . $addressData['billing']['pincode'] . ', ' . $addressData['billing']['country'],
            ]);
            Log::info('New order created', ['order_id' => $order->id]);

            foreach ($cartItems as $cartKey => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'attributes' => json_encode($item['attributes'] ?? []),
                ]);
            }
            Log::info('Order items created', ['order_id' => $order->id, 'item_count' => count($cartItems)]);

            DB::commit();
            Log::info('Transaction committed');

            if ($coupon && $coupon->usage_limit) {
                $coupon->increment('used');
                if ($coupon->fresh()->used >= $coupon->usage_limit) {
                    $coupon->update(['status' => 0]);
                }
            }
            Log::info('Coupon usage updated', ['coupon_code' => $couponCode]);

            // Store order_id and cart hash in session
            session(['order_id' => $order->id, 'cart_hash' => $currentCartHash]);
            Log::info('Session updated with order_id and cart_hash', [
                'order_id' => $order->id,
                'cart_hash' => $currentCartHash,
                'session_data' => session()->all()
            ]);

            return redirect()->route('checkout.payment', $order->id)->with('success', 'Proceed to payment.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'session' => session()->all(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('checkout')->with('error', 'Something went wrong during order creation!');
        }
    }

    public function saveAddress(Request $request)
    {
        Log::info('Save address method started', ['request' => $request->all()]);

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address1' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'checkmethod' => 'required|in:same,different',
        ];

        $request->validate($rules);
        Log::info('Validation passed', ['rules' => $rules]);

        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            Log::warning('No authenticated customer');
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }
        Log::info('Customer authenticated', ['customer_id' => $customer->id]);

        $cartItems = app(CartController::class)->getCartItems();
        if (empty($cartItems)) {
            Log::warning('Cart is empty');
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }
        Log::info('Cart items retrieved', ['item_count' => count($cartItems)]);

        $shippingName = $request->first_name . ' ' . $request->last_name;
        $shippingAddress = $request->address1 . ($request->address2 ? ' ' . $request->address2 : '');

        $addressData = [
            'shipping' => [
                'name' => $shippingName,
                'address' => $shippingAddress,
                'city' => $request->city,
                'state' => '',
                'pincode' => $request->postal_code,
                'country' => $request->country,
            ]
        ];

        if ($request->checkmethod === 'same') {
            $addressData['billing'] = $addressData['shipping'];
        } else {
            $defaultAddress = $customer->addresses()->where('is_default', true)->first();
            $addressData['billing'] = $defaultAddress ? [
                'name' => $defaultAddress->name,
                'address' => $defaultAddress->address,
                'city' => $defaultAddress->city,
                'state' => $defaultAddress->state ?? '',
                'pincode' => $defaultAddress->pincode,
                'country' => $defaultAddress->country ?? 'India',
            ] : $addressData['shipping'];
        }

        DB::beginTransaction();
        try {
            // Check if shipping address already exists
            if (!$this->addressExists($customer->id, $addressData['shipping'])) {
                $isDefault = !$customer->addresses()->where('is_default', true)->exists();
                Address::create([
                    'customer_id' => $customer->id,
                    'name' => $addressData['shipping']['name'],
                    'address' => $addressData['shipping']['address'],
                    'city' => $addressData['shipping']['city'],
                    'state' => $addressData['shipping']['state'],
                    'pincode' => $addressData['shipping']['pincode'],
                    'country' => $addressData['shipping']['country'],
                    'phone' => $customer->contact_no,
                    'email' => $customer->email,
                    'is_default' => $isDefault,
                ]);
                Log::info('New shipping address created', ['customer_id' => $customer->id]);
            } else {
                Log::info('Shipping address already exists, skipping creation', ['customer_id' => $customer->id]);
            }

            // Only create a separate billing address if it differs and a default already exists
            if ($request->checkmethod === 'different' && !$this->addressExists($customer->id, $addressData['billing'])) {
                Address::create([
                    'customer_id' => $customer->id,
                    'name' => $addressData['billing']['name'],
                    'address' => $addressData['billing']['address'],
                    'city' => $addressData['billing']['city'],
                    'state' => $addressData['billing']['state'],
                    'pincode' => $addressData['billing']['pincode'],
                    'country' => $addressData['billing']['country'],
                    'phone' => $customer->contact_no,
                    'email' => $customer->email,
                    'is_default' => false,
                ]);
                Log::info('New billing address created', ['customer_id' => $customer->id]);
            } else {
                Log::info('Billing address already exists or same as shipping, skipping creation', ['customer_id' => $customer->id]);
            }

            DB::commit();
            Log::info('Addresses saved to database', ['customer_id' => $customer->id]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save addresses', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('checkout')->with('error', 'Failed to save address. Please try again.');
        }

        // Store address data in session for display purposes
        Session::put('checkout_address', $addressData);
        Log::info('Address data saved to session', ['address_data' => $addressData]);

        return redirect()->route('checkout')->with('success', 'Address saved successfully. Proceed to payment.');
    }

    protected function addressExists($customerId, $addressData)
    {
        return Address::where('customer_id', $customerId)
            ->where('name', $addressData['name'])
            ->where('address', $addressData['address'])
            ->where('city', $addressData['city'])
            ->where('pincode', $addressData['pincode'])
            ->where('country', $addressData['country'])
            ->exists();
    }

    public function payment($orderId = null)
    {
        Log::info('Payment method called', [
            'orderId' => $orderId,
            'session_order_id' => session('order_id'),
            'session_success' => session('success'),
            'all_session' => session()->all()
        ]);

        if (!$orderId && !session('order_id')) {
            Log::warning('Payment method called without orderId', ['session' => session()->all()]);
            return redirect()->route('checkout')->with('error', 'Please complete the checkout form first');
        }

        $orderId = $orderId ?: session('order_id');
        $order = Order::with(['items.product', 'customer'])->findOrFail($orderId);
        Log::info('Order retrieved', ['orderId' => $orderId, 'customerId' => $order->customer_id]);

        if ($order->customer_id != Auth::guard('customer')->id()) {
            Log::warning('Order does not belong to authenticated customer', [
                'orderId' => $orderId,
                'customerId' => Auth::guard('customer')->id()
            ]);
            return redirect()->route('checkout')->with('error', 'Order not found');
        }

        $cartSummary = $this->getCartSummary($order);
        $gateways = PaymentGateway::where('status', 1)->get();

        return view('store.pages.payment', compact('order', 'cartSummary', 'gateways'));
    }

    // public function initiatePayment(Request $request, $orderId)
    // {
    //     Log::info('Initiate payment called', ['orderId' => $orderId, 'request' => $request->all()]);

    //     $order = Order::with('customer')->findOrFail($orderId);
    //     if (Auth::guard('customer')->id() !== $order->customer_id) {
    //         Log::warning('Unauthorized access to order', ['orderId' => $orderId, 'customerId' => Auth::guard('customer')->id()]);
    //         return $request->wantsJson()
    //             ? response()->json(['success' => false, 'message' => 'Unauthorized access to order.'], 403)
    //             : abort(403);
    //     }

    //     // Check if payment is already initiated
    //     if (in_array($order->payment_status, ['pending', 'paid'])) {
    //         Log::info('Payment already initiated for order', ['orderId' => $orderId, 'payment_status' => $order->payment_status]);
    //         return $request->wantsJson()
    //             ? response()->json(['success' => true, 'message' => 'Payment already processed. Redirecting to success page.'])
    //             : redirect()->route('checkout.success', $order->id);
    //     }

    //     $request->validate([
    //         'gateway_key' => 'required|string',
    //     ]);

    //     $gatewayKey = $request->gateway_key;

    //     DB::beginTransaction();
    //     try {
    //         if ($gatewayKey === 'cod') {
    //             $order->update([
    //                 'payment_method' => 'cod',
    //                 'payment_status' => 'pending',
    //                 'status' => 'processing',
    //             ]);
    //         } else {
    //             $gateway = PaymentGateway::where('gateway_key', $gatewayKey)->where('status', 1)->firstOrFail();
    //             $order->update([
    //                 'payment_method' => $gateway->gateway_key,
    //                 'payment_status' => 'paid',
    //                 'status' => 'processing',
    //             ]);
    //         }

    //         // Clear session only after successful payment initiation
    //         Session::forget(['cart', 'coupon_code', 'checkout_address', 'order_id']);
    //         Log::info('Payment initiated and session cleared', ['orderId' => $orderId, 'gateway' => $gatewayKey]);

    //         DB::commit();

    //         return $request->wantsJson()
    //             ? response()->json(['success' => true, 'message' => 'Payment initiated successfully!'])
    //             : redirect()->route('checkout.success', $order->id);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Log::error('Payment initiation failed', [
    //             'orderId' => $orderId,
    //             'gateway' => $gatewayKey,
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         return $request->wantsJson()
    //             ? response()->json(['success' => false, 'message' => 'Failed to initiate payment. Please try again.'], 500)
    //             : redirect()->route('checkout.payment', $order->id)->with('error', 'Failed to initiate payment. Please try again.');
    //     }
    // }

    // public function initiatePayment(Request $request, $orderId)
    // {
    //     Log::info('Initiate payment started', ['order_id' => $orderId, 'request' => $request->all()]);

    //     $customer = Auth::guard('customer')->user();
    //     if (!$customer) {
    //         Log::warning('No authenticated customer');
    //         return response()->json(['success' => false, 'message' => 'Please login to proceed with payment.']);
    //     }

    //     $order = Order::where('id', $orderId)
    //         ->where('customer_id', $customer->id)
    //         ->where('status', 'pending')
    //         ->where('payment_status', 'pending')
    //         ->first();

    //     if (!$order) {
    //         Log::warning('Invalid or non-pending order', ['order_id' => $orderId]);
    //         return response()->json(['success' => false, 'message' => 'Invalid order or payment already processed.']);
    //     }

    //     $gatewayKey = $request->input('gateway_key');
    //     $gateway = PaymentGateway::where('gateway_key', $gatewayKey)->first();

    //     if (!$gateway) {
    //         Log::warning('Invalid payment gateway', ['gateway_key' => $gatewayKey]);
    //         return response()->json(['success' => false, 'message' => 'Invalid payment gateway selected.']);
    //     }

    //     try {
    //         // Simulate payment processing (replace with actual gateway logic, e.g., Razorpay, Stripe)
    //         if ($gatewayKey === 'cod') {
    //             $order->update([
    //                 'payment_status' => 'completed',
    //                 'payment_method' => 'cod',
    //                 'status' => 'confirmed'
    //             ]);
    //             Log::info('COD payment processed', ['order_id' => $orderId]);
    //         } else {
    //             // Add logic for other gateways
    //             Log::info('Processing online payment', ['gateway_key' => $gatewayKey]);
    //             $order->update([
    //                 'payment_status' => 'completed',
    //                 'payment_method' => $gatewayKey,
    //                 'status' => 'confirmed'
    //             ]);
    //         }

    //         // Clear session data, including cart
    //         Session::forget(['cart', 'coupon_code', 'checkout_address', 'order_id', 'cart_hash']);
    //         // Set flag to indicate order completion
    //         Session::put('order_completed', true);
    //         Log::info('Session cleared after payment', [
    //             'order_id' => $orderId,
    //             'session_data' => session()->all()
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Payment processed successfully!'
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Payment processing failed', [
    //             'order_id' => $orderId,
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to process payment. Please try again.'
    //         ]);
    //     }
    // }

    public function initiatePayment(Request $request, $orderId)
    {
        Log::info('Initiate payment started', ['order_id' => $orderId, 'request' => $request->all()]);

        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            Log::warning('No authenticated customer');
            return response()->json(['success' => false, 'message' => 'Please login to proceed with payment.']);
        }

        $order = Order::where('id', $orderId)
            ->where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->where('payment_status', 'pending')
            ->first();

        if (!$order) {
            Log::warning('Invalid or non-pending order', ['order_id' => $orderId]);
            return response()->json(['success' => false, 'message' => 'Invalid order or payment already processed.']);
        }

        $gatewayKey = $request->input('gateway_key');
        $gateway = PaymentGateway::where('gateway_key', $gatewayKey)->first();

        if (!$gateway) {
            Log::warning('Invalid payment gateway', ['gateway_key' => $gatewayKey]);
            return response()->json(['success' => false, 'message' => 'Invalid payment gateway selected.']);
        }

        try {
            if ($gatewayKey === 'cod') {
                $order->update([
                    'payment_status' => 'pending', // Keep pending for admin to update
                    'payment_method' => 'cod',
                    'status' => 'pending' // Keep pending for admin to update
                ]);
                Log::info('COD payment initiated, status pending', ['order_id' => $orderId]);
            } else {
                // Process online payment (e.g., Razorpay, Stripe)
                Log::info('Processing online payment', ['gateway_key' => $gatewayKey]);
                $order->update([
                    'payment_status' => 'completed', // Online payments complete immediately
                    'payment_method' => $gatewayKey,
                    'status' => 'confirmed'
                ]);
            }

            // Clear session data, including cart
            Session::forget(['cart', 'coupon_code', 'checkout_address', 'order_id', 'cart_hash']);
            Session::put('order_completed', true);
            Log::info('Session cleared after payment', [
                'order_id' => $orderId,
                'session_data' => session()->all()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment initiated successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Payment processing failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment. Please try again.'
            ]);
        }
    }

    public function success($orderId)
    {
        $order = Order::with(['items.product', 'customer'])->findOrFail($orderId);
        if (Auth::guard('customer')->id() !== $order->customer_id) {
            abort(403);
        }

        return view('store.pages.checkout-success', compact('order'));
    }

    protected function getCartSummary($order)
    {
        $subtotal = $order->subtotal;
        $tax = $order->tax;
        $shipping = $order->shipping;
        $couponDiscount = $order->discount;
        $grandTotal = $order->total;

        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'couponDiscount' => $couponDiscount,
            'grandTotal' => $grandTotal,
        ];
    }
}
