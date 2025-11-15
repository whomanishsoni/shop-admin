<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\{Customer, Order, OrderItem, Address, Coupon, PaymentGateway, Transaction};
use App\Http\Controllers\Store\CartController;
use App\Services\RazorpayService;
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

        $customer = Auth::guard('customer')->user();
        $defaultAddress = null;
        $isGuest = !$customer;

        if ($customer) {
            $defaultAddress = $customer->addresses()->where('is_default', true)->first();
        }

        $cartSummary = [
            'items' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'couponDiscount' => $couponDiscount,
            'couponCode' => $couponCode,
            'grandTotal' => $grandTotal,
            'defaultAddress' => $defaultAddress,
            'isGuest' => $isGuest,
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

    public function createOrderAndPayment(Request $request)
    {
        Log::info('Create order and payment method started', [
            'request' => $request->all(),
            'session_order_id' => session('order_id'),
            'session_cart_hash' => session('cart_hash'),
            'session_data' => session()->all()
        ]);

        $customer = Auth::guard('customer')->user();
        $isGuest = !$customer;

        $cartItems = app(CartController::class)->getCartItems();
        if (empty($cartItems)) {
            Log::warning('Cart is empty');
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Handle guest vs authenticated user addresses
        if ($isGuest) {
            // For guests, check if address data is in session (from saveAddress) or request
            $sessionAddress = Session::get('checkout_address');

            if ($sessionAddress) {
                $addressData = $sessionAddress;
            } elseif ($request->has(['first_name', 'email', 'phone', 'address1', 'city', 'postal_code', 'country'])) {
                // Extract address data from the request
                $addressData = [
                    'shipping' => [
                        'name' => $request->first_name . ' ' . $request->last_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address1 . ($request->address2 ? ' ' . $request->address2 : ''),
                        'city' => $request->city,
                        'state' => '',
                        'pincode' => $request->postal_code,
                        'country' => $request->country,
                    ]
                ];
                $addressData['billing'] = $addressData['shipping']; // Same as shipping for guests
            } else {
                Log::warning('Guest checkout attempted without address information', [
                    'request' => $request->all(),
                    'session' => session()->all()
                ]);
                return redirect()->route('checkout')->with('error', 'Please provide your address information before proceeding to payment.');
            }
        } else {
            // Fetch the latest address and default address for authenticated users
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
        }

        // Generate a hash of the current cart items
        $currentCartHash = md5(json_encode($cartItems));
        Log::info('Current cart hash generated', ['cart_hash' => $currentCartHash]);

        // Check for existing pending order in session
        $existingOrderId = session('order_id');
        if ($existingOrderId) {
            $existingOrderQuery = Order::where('id', $existingOrderId)
                ->where('status', 'pending')
                ->where('payment_status', 'pending');

            // For authenticated users, also check customer_id
            if (!$isGuest) {
                $existingOrderQuery->where('customer_id', $customer->id);
            }

            $existingOrder = $existingOrderQuery->first();

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

            $orderData = [
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
            ];

            // Add customer or guest information
            if ($isGuest) {
                $orderData['guest_name'] = $addressData['shipping']['name'];
                $orderData['guest_email'] = $addressData['shipping']['email'] ?? null;
                $orderData['guest_phone'] = $addressData['shipping']['phone'] ?? null;
                $orderData['customer_id'] = null;
            } else {
                $orderData['customer_id'] = $customer->id;
            }

            $order = Order::create($orderData);
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

            // Clear cart after successful order creation
            Session::forget('cart');
            Log::info('Cart cleared after order creation', ['order_id' => $order->id]);

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
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address1' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'checkmethod' => 'required|in:same,different',
        ];

        $request->validate($rules);
        Log::info('Validation passed', ['rules' => $rules]);

        $customer = Auth::guard('customer')->user();
        $isGuest = !$customer;

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
                'email' => $request->email,
                'phone' => $request->phone,
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
            if ($isGuest) {
                // For guests, use same as shipping if different is selected (simplified)
                $addressData['billing'] = $addressData['shipping'];
            } else {
                $defaultAddress = $customer->addresses()->where('is_default', true)->first();
                $addressData['billing'] = $defaultAddress ? [
                    'name' => $defaultAddress->name,
                    'email' => $customer->email,
                    'phone' => $customer->contact_no,
                    'address' => $defaultAddress->address,
                    'city' => $defaultAddress->city,
                    'state' => $defaultAddress->state ?? '',
                    'pincode' => $defaultAddress->pincode,
                    'country' => $defaultAddress->country ?? 'India',
                ] : $addressData['shipping'];
            }
        }

        if (!$isGuest) {
            // For authenticated users, save to database
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
        }

        // Store address data in session for both guests and authenticated users
        Session::put('checkout_address', $addressData);
        Log::info('Address data saved to session', ['address_data' => $addressData, 'is_guest' => $isGuest]);

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

        $customer = Auth::guard('customer')->user();
        $isGuest = !$customer;

        // Check if order belongs to authenticated customer OR is a guest order with valid session
        $hasAccess = false;
        if (!$isGuest && $order->customer_id == $customer->id) {
            $hasAccess = true;
        } elseif ($isGuest && is_null($order->customer_id) && session('order_id') == $orderId) {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            Log::warning('Order access denied', [
                'orderId' => $orderId,
                'customerId' => $order->customer_id,
                'authenticatedCustomerId' => $customer ? $customer->id : null,
                'isGuest' => $isGuest,
                'sessionOrderId' => session('order_id')
            ]);
            return redirect()->route('checkout')->with('error', 'Order not found');
        }

        $cartSummary = $this->getCartSummary($order);
        $gateways = PaymentGateway::where('status', 1)->get();

        return view('store.pages.payment', compact('order', 'cartSummary', 'gateways'));
    }

    public function initiatePayment(Request $request, $orderId)
    {
        Log::info('Initiate payment started', ['order_id' => $orderId, 'request' => $request->all()]);

        $customer = Auth::guard('customer')->user();
        $isGuest = !$customer;

        // Build order query based on authentication status
        $orderQuery = Order::where('id', $orderId)
            ->where('status', 'pending')
            ->where('payment_status', 'pending');

        if (!$isGuest) {
            $orderQuery->where('customer_id', $customer->id);
        } else {
            $orderQuery->whereNull('customer_id');
        }

        $order = $orderQuery->first();

        if (!$order) {
            Log::warning('Invalid or non-pending order', ['order_id' => $orderId, 'is_guest' => $isGuest]);
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

                // Clear session data, including cart
                Session::forget(['cart', 'coupon_code', 'checkout_address', 'order_id', 'cart_hash']);
                Session::put('order_completed', true);

                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully!',
                    'redirect' => route('checkout.success', $orderId)
                ]);
            } elseif ($gatewayKey === 'razorpay') {
                $razorpayService = app(RazorpayService::class);
                $razorpayOrder = $razorpayService->createOrder($order);

                $order->update([
                    'payment_method' => 'razorpay',
                    'razorpay_order_id' => $razorpayOrder->id
                ]);

                Log::info('Razorpay order created for payment', [
                    'order_id' => $orderId,
                    'razorpay_order_id' => $razorpayOrder->id
                ]);

                return response()->json([
                    'success' => true,
                    'gateway' => 'razorpay',
                    'razorpay_order_id' => $razorpayOrder->id,
                    'amount' => $razorpayOrder->amount,
                    'currency' => $razorpayOrder->currency,
                    'key' => $razorpayService->getKeyId(),
                    'name' => config('app.name', 'Shop'),
                    'description' => 'Order #' . $order->order_number,
                    'customer' => [
                        'name' => $isGuest ? $order->guest_name : $customer->name,
                        'email' => $isGuest ? $order->guest_email : $customer->email,
                        'contact' => $isGuest ? $order->guest_phone : $customer->contact_no
                    ],
                    'callback_url' => route('checkout.razorpay.callback'),
                    'order_id' => $order->id
                ]);
            } else {
                // Handle other payment gateways here
                Log::info('Processing other online payment', ['gateway_key' => $gatewayKey]);
                $order->update([
                    'payment_status' => 'paid',
                    'payment_method' => $gatewayKey,
                    'status' => 'confirmed'
                ]);

                // Create transaction record for other online payments
                \App\Models\Transaction::create([
                    'order_id' => $order->id,
                    'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                    'amount' => $order->total,
                    'currency' => 'INR',
                    'payment_method' => $gatewayKey,
                    'payment_gateway' => $gatewayKey,
                    'status' => 'paid',
                    'payment_date' => now()
                ]);

                // Create customer account for guest orders
                $createdCustomer = null;
                if (is_null($order->customer_id)) {
                    $createdCustomer = $this->handleGuestAccountCreation($order->fresh());
                    if ($createdCustomer) {
                        Auth::guard('customer')->login($createdCustomer);
                        Log::info('Guest customer logged in after account creation', [
                            'customer_id' => $createdCustomer->id,
                            'order_id' => $order->id
                        ]);
                    }
                }

                // Clear session data, including cart
                Session::forget(['cart', 'coupon_code', 'checkout_address', 'order_id', 'cart_hash']);
                Session::put('order_completed', true);

                // Redirect to profile if guest account was created, otherwise to success page
                $redirectRoute = $createdCustomer ? route('profile') : route('checkout.success', $orderId);
                $successMessage = $createdCustomer ? 'Account created successfully! Welcome to our store.' : 'Payment completed successfully!';

                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'redirect' => $redirectRoute
                ]);
            }
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

        $customer = Auth::guard('customer')->user();
        $isGuest = !$customer;

        // Check if order belongs to authenticated customer OR is a guest order with valid session
        $hasAccess = false;
        if (!$isGuest && $order->customer_id == $customer->id) {
            $hasAccess = true;
        } elseif ($isGuest && is_null($order->customer_id) && session('order_completed')) {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            abort(403, 'Unauthorized access to order');
        }

        return view('store.pages.checkout-success', compact('order'));
    }

    public function completeRazorpayPayment(Request $request, $orderId)
    {
        Log::info('Manual Razorpay payment completion requested', ['order_id' => $orderId]);

        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Please login to proceed.']);
        }

        $order = Order::where('id', $orderId)
            ->where('customer_id', $customer->id)
            ->where('payment_method', 'razorpay')
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found.']);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['success' => false, 'message' => 'Payment already completed.']);
        }

        try {
            $razorpayService = app(RazorpayService::class);

            // For testing, we'll simulate a successful payment
            $fakePaymentId = 'pay_' . strtoupper(uniqid());
            $razorpayOrderId = $order->razorpay_order_id ?: 'order_' . strtoupper(uniqid());

            $razorpayService->processPaymentSuccess($order, $razorpayOrderId, $fakePaymentId);

            // Clear session data
            Session::forget(['cart', 'coupon_code', 'checkout_address', 'order_id', 'cart_hash']);
            Session::put('order_completed', true);

            Log::info('Manual Razorpay payment completion successful', ['order_id' => $orderId]);

            return response()->json([
                'success' => true,
                'message' => 'Payment completed successfully!',
                'redirect' => route('checkout.success', $orderId)
            ]);
        } catch (\Exception $e) {
            Log::error('Manual payment completion failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to complete payment. Please try again.'
            ]);
        }
    }

    public function testRazorpayCallback(Request $request, $orderId)
    {
        Log::info('Test Razorpay callback triggered', ['order_id' => $orderId]);

        $order = Order::findOrFail($orderId);

        if (!$order->razorpay_order_id) {
            return response()->json(['error' => 'Order does not have Razorpay order ID']);
        }

        // Simulate callback data
        $testData = [
            'razorpay_order_id' => $order->razorpay_order_id,
            'razorpay_payment_id' => 'pay_' . strtoupper(uniqid()),
            'razorpay_signature' => 'test_signature_' . time()
        ];

        // Call the actual callback method
        $callbackRequest = new Request($testData);
        return $this->razorpayCallback($callbackRequest);
    }

    public function razorpayCallback(Request $request)
    {
        Log::info('Razorpay callback received', ['request' => $request->all()]);

        $razorpayOrderId = $request->input('razorpay_order_id');
        $razorpayPaymentId = $request->input('razorpay_payment_id');
        $razorpaySignature = $request->input('razorpay_signature');

        if (!$razorpayOrderId || !$razorpayPaymentId || !$razorpaySignature) {
            Log::error('Missing required Razorpay callback parameters');
            return redirect()->route('checkout')->with('error', 'Payment verification failed. Please try again.');
        }

        try {
            $razorpayService = app(RazorpayService::class);

            // Check if we're in test mode - skip signature verification for testing
            $gateway = \App\Models\PaymentGateway::where('gateway_key', 'razorpay')->first();
            $isTestMode = $gateway && $gateway->mode === 'test';

            // Find the order by razorpay_order_id
            $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();

            if (!$order) {
                Log::error('Order not found for Razorpay order ID', ['razorpay_order_id' => $razorpayOrderId]);
                return redirect()->route('checkout')->with('error', 'Order not found.');
            }

            // Verify the customer (skip for test mode)
            $customerId = Auth::guard('customer')->id();
            if (!$isTestMode && $order->customer_id != $customerId) {
                Log::warning('Order does not belong to authenticated customer', [
                    'order_id' => $order->id,
                    'customer_id' => $customerId
                ]);
                return redirect()->route('checkout')->with('error', 'Unauthorized access.');
            }

            if ($isTestMode || $razorpayService->verifyPayment($razorpayOrderId, $razorpayPaymentId, $razorpaySignature)) {
                // Payment successful
                $razorpayService->processPaymentSuccess($order, $razorpayOrderId, $razorpayPaymentId);

                // Create customer account for guest orders
                $createdCustomer = null;
                if (is_null($order->customer_id)) {
                    $createdCustomer = $this->handleGuestAccountCreation($order->fresh());
                    if ($createdCustomer) {
                        Auth::guard('customer')->login($createdCustomer);
                        Log::info('Guest customer logged in after account creation', [
                            'customer_id' => $createdCustomer->id,
                            'order_id' => $order->id
                        ]);
                    }
                }

                // Clear session data
                Session::forget(['cart', 'coupon_code', 'checkout_address', 'order_id', 'cart_hash']);
                Session::put('order_completed', true);

                Log::info('Razorpay payment successful', [
                    'order_id' => $order->id,
                    'razorpay_payment_id' => $razorpayPaymentId,
                    'test_mode' => $isTestMode,
                    'guest_account_created' => !is_null($createdCustomer)
                ]);

                // Redirect to profile if guest account was created, otherwise to success page
                if ($createdCustomer) {
                    return redirect()->route('profile')->with('success', 'Account created successfully! Welcome to our store.');
                } else {
                    return redirect()->route('checkout.success', $order->id)->with('success', 'Payment completed successfully!');
                }
            } else {
                // Payment verification failed
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled'
                ]);

                Log::error('Razorpay payment verification failed', [
                    'order_id' => $order->id,
                    'razorpay_order_id' => $razorpayOrderId,
                    'razorpay_payment_id' => $razorpayPaymentId
                ]);

                return redirect()->route('checkout.payment', $order->id)->with('error', 'Payment verification failed. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Razorpay callback processing failed', [
                'error' => $e->getMessage(),
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('checkout')->with('error', 'Payment processing failed. Please contact support.');
        }
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

    protected function handleGuestAccountCreation($order)
    {
        // Only create account for guest orders that are paid
        if ($order->customer_id || $order->payment_status !== 'paid') {
            return null;
        }

        try {
            DB::beginTransaction();

            // Check if customer already exists with this email
            $existingCustomer = Customer::where('email', $order->guest_email)->first();

            if ($existingCustomer) {
                // Link existing customer to order
                $order->update(['customer_id' => $existingCustomer->id]);
                DB::commit();
                return $existingCustomer;
            }

            // Create new customer account
            $nameParts = explode(' ', $order->guest_name, 2);
            $customer = Customer::create([
                'first_name' => $nameParts[0] ?? '',
                'last_name' => $nameParts[1] ?? '',
                'email' => $order->guest_email,
                'contact_no' => $order->guest_phone,
                'password' => bcrypt(Str::random(12)), // Generate random password
                'email_verified_at' => now(), // Auto-verify since they just paid
            ]);

            // Create address from order shipping info
            $addressParts = explode(', ', $order->shipping_address);
            $city = $addressParts[count($addressParts) - 3] ?? '';
            $pincode = $addressParts[count($addressParts) - 2] ?? '';
            $country = $addressParts[count($addressParts) - 1] ?? 'India';

            // Extract address without city/pincode/country
            $address = implode(', ', array_slice($addressParts, 0, -3));

            Address::create([
                'customer_id' => $customer->id,
                'name' => $order->guest_name,
                'email' => $order->guest_email,
                'phone' => $order->guest_phone,
                'address' => $address,
                'city' => $city,
                'pincode' => $pincode,
                'country' => $country,
                'is_default' => true,
            ]);

            // Link order to customer
            $order->update(['customer_id' => $customer->id]);

            DB::commit();

            Log::info('Guest account created after payment', [
                'order_id' => $order->id,
                'customer_id' => $customer->id,
                'customer_email' => $customer->email
            ]);

            return $customer;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create guest account', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}
