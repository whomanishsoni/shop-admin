<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function show($slug)
    {
        // Fetch the product with related data
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with([
                'category',
                'subcategory',
                'brand',
                'images' => function ($query) {
                    $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
                },
                'reviews' => function ($query) {
                    $query->where('approved', true)->with('customer');
                },
                'attributeValues.attribute'
            ])
            ->firstOrFail();

        // Prepare product data for the view
        $productData = [
            'slug' => $product->slug,
            'name' => $product->name,
            'price' => $product->sale_price ?? $product->price,
            'old_price' => $product->sale_price && $product->sale_price < $product->price ? $product->price : null,
            'on_sale' => !is_null($product->sale_price) && $product->sale_price < $product->price,
            'images' => $product->images->map(function ($image) {
                return asset('storage/' . $image->image);
            })->toArray(),
            'description' => $product->description,
            'short_description' => $product->short_description,
            'sku' => $product->sku,
            'category_name' => $product->category ? $product->category->name : 'Products',
            'category_slug' => $product->category ? $product->category->slug : null,
            'brand_name' => $product->brand ? $product->brand->name : null,
            'brand_slug' => $product->brand ? $product->brand->slug : null,
            'attributes' => $product->attributeValues->groupBy('attribute.name')->map(function ($values, $attributeName) {
                return [
                    'name' => $attributeName,
                    'values' => $values->map(function ($value) {
                        $decodedValue = is_array($value->value) ? $value->value : (json_decode($value->value, true) ?: [$value->value]);
                        return [
                            'value' => $decodedValue,
                            'image' => $value->image ? asset('storage/' . $value->image) : null,
                        ];
                    })->toArray(),
                ];
            })->values()->toArray(),
            'reviews' => $product->reviews->map(function ($review) {
                return [
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'customer_name' => $review->customer ? $review->customer->name : 'Anonymous',
                    'date' => $review->created_at->format('M d, Y'),
                    'approved' => $review->approved,
                ];
            })->toArray(),
            'average_rating' => $product->reviews->avg('rating') ?: 0,
            'review_count' => $product->reviews->count(),
        ];

        // Log product data for debugging
        Log::info('Product Data: ', $productData);

        // Fetch related products (same category or subcategory, excluding current product)
        $relatedProducts = Product::where('status', 'active')
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                      ->orWhere('subcategory_id', $product->subcategory_id);
            })
            ->with(['images' => function ($query) {
                $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
            }])
            ->take(4)
            ->get()
            ->map(function ($related) use ($product) {
                $primaryImage = $related->images->first();
                $secondaryImage = $related->images->skip(1)->first() ?? $primaryImage;
                return [
                    'slug' => $related->slug,
                    'name' => $related->name,
                    'price' => $related->sale_price ?? $related->price,
                    'old_price' => $related->sale_price && $related->sale_price < $related->price ? $related->price : null,
                    'image_primary' => $primaryImage ? asset('storage/' . $primaryImage->image) : asset('assets/images/product/placeholder.jpg'),
                    'image_secondary' => $secondaryImage ? asset('storage/' . $secondaryImage->image) : asset('assets/images/product/placeholder.jpg'),
                    'on_sale' => !is_null($related->sale_price) && $related->sale_price < $related->price,
                ];
            });

        return view('store.pages.product-detail', compact('productData', 'relatedProducts'));
    }
}
