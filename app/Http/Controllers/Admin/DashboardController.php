<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count() ?? 0,
            'orders' => Order::count() ?? 0,
            'customers' => Customer::count() ?? 0,
            'revenue' => Order::where('status', 'completed')->sum('total') ?? 0
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
