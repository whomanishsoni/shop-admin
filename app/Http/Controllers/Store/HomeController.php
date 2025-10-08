<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Example: Fetch latest products (assuming a Product model)
        // Replace with your actual logic, e.g., Product::latest()->take(4)->get();
        $products = []; // Placeholder for dynamic data

        // Pass data to the view
        return view('store.pages.home', compact('products'));
    }
}
