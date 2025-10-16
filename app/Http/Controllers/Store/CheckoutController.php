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
        $shippingAddress = $request->address1 . ($request->address2 ? ' ' . $request->address2 : '') . ', ' . $request->city . ', ' . $request->postal_code . ', ' . $request->country;

        $addressData = [
            'shipping' => [
                'name' => $shippingName,
                'address' => $request->address1 . ' ' . ($request->address2 ?? ''),
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
            // Store shipping address as default if no default exists
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
                'type' => 'shipping',
            ]);

            // Only create a separate billing address if it differs and a default already exists
            if ($request->checkmethod === 'different' && $isDefault === false && $addressData['shipping'] !== $addressData['billing']) {
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
                    'type' => 'billing',
                ]);
            }

            DB::commit();
            Log::info('Addresses saved to database', ['customer_id' => $customer->id]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save addresses', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('checkout')->with('error', 'Failed to save address. Please try again.');
        }

        Session::put('checkout_address', $addressData);
        Log::info('Address data saved to session', ['address_data' => $addressData]);

        return redirect()->route('checkout')->with('success', 'Address saved successfully. Proceed to payment.');
    }

    public function createOrderAndPayment(Request $request)
    {
        Log::info('Create order and payment method started', ['request' => $request->all(), 'session_order_id' => session('order_id')]);

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

        $addressData = Session::get('checkout_address');
        if (!$addressData || !isset($addressData['shipping']) || !isset($addressData['billing'])) {
            Log::warning('Address data missing in session', ['session' => session()->all()]);
            return redirect()->route('checkout')->with('error', 'Please complete the checkout form first');
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
                'shipping_address' => $addressData['shipping']['address'],
                'billing_address' => $addressData['billing']['address'],
            ]);
            Log::info('Order created', ['order_id' => $order->id]);

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
                'is_default' => !$customer->addresses()->where('is_default', true)->exists(),
                'type' => 'shipping',
            ]);

            if ($addressData['shipping'] !== $addressData['billing']) {
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
                    'is_default' => !$customer->addresses()->where('is_default', true)->exists(),
                    'type' => 'billing',
                ]);
            }
            Log::info('Addresses saved', ['order_id' => $order->id]);

            DB::commit();
            Log::info('Transaction committed');

            if ($coupon && $coupon->usage_limit) {
                $coupon->increment('used');
                if ($coupon->fresh()->used >= $coupon->usage_limit) {
                    $coupon->update(['status' => 0]);
                }
            }
            Log::info('Coupon usage updated', ['coupon_code' => $couponCode]);

            session(['order_id' => $order->id]);
            Log::info('Session updated with order_id', ['order_id' => $order->id, 'session_data' => session()->all()]);

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

    public function initiatePayment(Request $request, $orderId)
    {
        $order = Order::with('customer')->findOrFail($orderId);
        if (Auth::guard('customer')->id() !== $order->customer_id) {
            abort(403);
        }

        $request->validate([
            'gateway_key' => 'required|string',
        ]);

        $gatewayKey = $request->gateway_key;

        if ($gatewayKey === 'cod') {
            $order->update([
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'status' => 'processing',
            ]);
        } else {
            $gateway = PaymentGateway::where('gateway_key', $gatewayKey)->where('status', 1)->firstOrFail();
            $order->update([
                'payment_method' => $gateway->gateway_key,
            ]);
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);
        }

        Session::forget(['cart', 'coupon_code', 'checkout_address', 'order_id']);
        Log::info('Payment initiated and session cleared', ['orderId' => $orderId, 'gateway' => $gatewayKey]);

        return redirect()->route('checkout.success', $order->id);
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
