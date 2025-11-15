<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        Log::info('Orders index accessed', ['customer_id' => Auth::guard('customer')->id()]);
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            Log::warning('No authenticated customer');
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        $orders = Order::where('customer_id', $customer->id)
            ->latest()
            ->get();

        $profileData = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'contact_no' => $customer->contact_no,
            'alternative_contact_no' => $customer->alternative_contact_no,
        ];

        return view('store.pages.account.orders', compact('orders', 'profileData'));
    }

    public function invoice($id)
    {
        Log::info('Invoice accessed', ['order_id' => $id, 'customer_id' => Auth::guard('customer')->id()]);
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            Log::warning('No authenticated customer');
            return redirect()->route('login')->with('error', 'Please login to view your order.');
        }

        $order = Order::with(['items.product.images'])->findOrFail($id);
        if ($order->customer_id !== $customer->id) {
            Log::warning('Unauthorized access to order', ['order_id' => $id, 'customer_id' => $customer->id]);
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'confirmed', 'completed'])) {
            Log::warning('Invoice not available for order status', ['order_id' => $id, 'status' => $order->status]);
            return redirect()->route('orders')->with('error', 'Invoice not available for this order.');
        }

        return view('store.pages.account.invoice', compact('order'));
    }
}
