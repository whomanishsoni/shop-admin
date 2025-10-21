<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        // Check if the user has purchased and the product was completed and paid
        $customerId = Auth::id();
        $hasPurchased = Order::where('customer_id', $customerId)
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        // Debug logging
        Log::info('Review Submission Check: ', [
            'product_id' => $product->id,
            'customer_id' => $customerId,
            'hasPurchased' => $hasPurchased
        ]);

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'You can only review products from completed and paid orders.');
        }

        // Check if the user has already reviewed this product
        $existingReview = ProductReview::where('product_id', $product->id)
            ->where('customer_id', $customerId)
            ->exists();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product.');
        }

        ProductReview::create([
            'product_id' => $product->id,
            'customer_id' => $customerId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'approved' => false, // Pending approval
        ]);

        return redirect()->back()->with('success', 'Your review has been submitted and is pending approval.');
    }
}
