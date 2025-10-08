<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        // Static order data
        $orders = [
            [
                'id' => 1,
                'order_number' => '#VY-2231',
                'date' => 'Aug 14, 2025',
                'payment_status' => 'Paid',
                'status' => 'Unfulfilled',
                'total' => 6240.00,
                'liked' => false,
            ],
            [
                'id' => 2,
                'order_number' => '#VY-1534',
                'date' => 'Aug 12, 2025',
                'payment_status' => 'Paid',
                'status' => 'Fulfilled',
                'total' => 22000.00,
                'liked' => true,
            ],
            [
                'id' => 3,
                'order_number' => '#VY-1224',
                'date' => 'Aug 10, 2025',
                'payment_status' => 'Paid',
                'status' => 'Unfulfilled',
                'total' => 12000.00,
                'liked' => false,
            ],
            [
                'id' => 4,
                'order_number' => '#VY-164',
                'date' => 'Aug 02, 2025',
                'payment_status' => 'Paid',
                'status' => 'Unfulfilled',
                'total' => 25000.00,
                'liked' => false,
            ],
        ];

        return view('store.pages.account.orders', compact('orders'));
    }

    public function invoice($id)
    {
        // Static order data for invoice
        $orders = [
            1 => [
                'order_number' => '#VY-2231',
                'date' => 'Aug 14, 2025',
                'payment_status' => 'Paid',
                'status' => 'Unfulfilled',
                'total' => 6240.00,
            ],
            2 => [
                'order_number' => '#VY-1534',
                'date' => 'Aug 12, 2025',
                'payment_status' => 'Paid',
                'status' => 'Fulfilled',
                'total' => 22000.00,
            ],
            3 => [
                'order_number' => '#VY-1224',
                'date' => 'Aug 10, 2025',
                'payment_status' => 'Paid',
                'status' => 'Unfulfilled',
                'total' => 12000.00,
            ],
            4 => [
                'order_number' => '#VY-164',
                'date' => 'Aug 02, 2025',
                'payment_status' => 'Paid',
                'status' => 'Unfulfilled',
                'total' => 25000.00,
            ],
        ];

        $order = $orders[$id] ?? null;

        if (!$order || $order['status'] !== 'Fulfilled') {
            return redirect()->route('orders')->with('error', 'Invoice not available for unfulfilled orders.');
        }

        return view('store.pages.account.invoice', compact('order'));
    }
}
