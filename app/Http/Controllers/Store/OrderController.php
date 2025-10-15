<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::where('customer_id', $customer->id)->latest()->get();

        return view('store.pages.account.orders', compact('orders'));
    }

    public function invoice($id)
    {
        $customer = Auth::guard('customer')->user();
        $order = Order::with(['items.product'])->findOrFail($id);
        if ($order->customer_id !== $customer->id) {
            abort(403);
        }

        if ($order->status !== 'completed') {
            return redirect()->route('orders')->with('error', 'Invoice not available for this order.');
        }

        return view('store.pages.account.invoice', compact('order'));
    }
}
