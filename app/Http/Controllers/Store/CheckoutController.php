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
                ->where(function($query) {
                    $query->whereNull('valid_from')
                          ->orWhere('valid_from', '<=', now());
                })
                ->where(function($query) {
                    $query->whereNull('valid_to')
                          ->orWhere('valid_to', '>=', now());
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
            ->where(function($query) {
                $query->whereNull('valid_from')
                      ->orWhere('valid_from', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('valid_to')
                      ->orWhere('valid_to', '>=', now());
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

    public function process(Request $request)
    {
        Log::info('Process method started', ['request' => $request->all()]);

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address1' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'checkmethod' => 'required|in:same,different',
        ];

        if ($request->checkmethod === 'different') {
            $rules = array_merge($rules, [
                'billing_first_name' => 'required|string|max:255',
                'billing_last_name' => 'required|string|max:255',
                'billing_address1' => 'required|string|max:500',
                'billing_city' => 'required|string|max:100',
                'billing_postal_code' => 'required|string|max:20',
                'billing_country' => 'required|string|max:100',
            ]);
        }

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

            $shippingName = $request->first_name . ' ' . $request->last_name;
            $shippingAddress = $request->address1 . ($request->address2 ? ' ' . $request->address2 : '') . ', ' . $request->city . ', ' . $request->postal_code . ', ' . $request->country;

            if ($request->checkmethod === 'same') {
                $billingName = $shippingName;
                $billingAddress = $shippingAddress;
            } else {
                $billingName = $request->billing_first_name . ' ' . $request->billing_last_name;
                $billingAddress = $request->billing_address1 . ($request->billing_address2 ? ' ' . $request->billing_address2 : '') . ', ' . $request->billing_city . ', ' . $request->billing_postal_code . ', ' . $request->billing_country;
            }
            Log::info('Addresses prepared', [
                'shipping_name' => $shippingName,
                'shipping_address' => $shippingAddress,
                'billing_name' => $billingName,
                'billing_address' => $billingAddress
            ]);

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
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
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
                'name' => $shippingName,
                'address' => $request->address1 . ' ' . ($request->address2 ?? ''),
                'city' => $request->city,
                'state' => '',
                'pincode' => $request->postal_code,
                'country' => $request->country,
                'phone' => $customer->contact_no,
                'email' => $customer->email,
                'is_default' => false,
                'type' => 'shipping',
            ]);

            if ($request->checkmethod === 'different') {
                Address::create([
                    'customer_id' => $customer->id,
                    'name' => $billingName,
                    'address' => $request->billing_address1 . ' ' . ($request->billing_address2 ?? ''),
                    'city' => $request->billing_city,
                    'state' => '',
                    'pincode' => $request->billing_postal_code,
                    'country' => $request->billing_country,
                    'phone' => $customer->contact_no,
                    'email' => $customer->email,
                    'is_default' => false,
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
            Log::info('Session updated with order_id', [
                'order_id' => $order->id,
                'session_data' => session()->all()
            ]);

            return redirect()->route('checkout')
                ->with('success', 'Order created successfully. Proceed to payment.')
                ->with('order_id', $order->id);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout process failed', [
                'error' => $e->getMessage(),
                'session' => session()->all(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Something went wrong! Please try again.');
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
            return redirect()->route('checkout')->with('error', 'Please complete checkout form first');
        }

        $orderId = $orderId ?: session('order_id');
        $order = Order::with(['items.product', 'customer', 'shippingAddress'])->findOrFail($orderId);
        Log::info('Order retrieved', ['orderId' => $orderId, 'customerId' => $order->customer_id]);

        if ($order->customer_id != Auth::guard('customer')->id()) {
            Log::warning('Order does not belong to authenticated customer', [
                'orderId' => $orderId,
                'customerId' => Auth::guard('customer')->id()
            ]);
            return redirect()->route('checkout')->with('error', 'Order not found');
        }

        $cartSummary = $this->getCartSummary();

        return view('store.pages.payment', compact('order', 'cartSummary'));
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

        Session::forget(['cart', 'coupon_code', 'order_id']);
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
}
