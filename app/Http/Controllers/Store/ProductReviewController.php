<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,slug',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product = Product::where('slug', $validated['product_id'])->firstOrFail();

        ProductReview::create([
            'product_id' => $product->id,
            'customer_id' => Auth::id(), // Uses web guard with customers provider
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'approved' => false, // Pending approval
        ]);

        return redirect()->back()->with('success', 'Your review has been submitted and is pending approval.');
    }
}
