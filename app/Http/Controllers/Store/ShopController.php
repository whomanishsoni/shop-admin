<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        // Fetch all active categories and subcategories
        $categories = Category::where('status', true)->with(['subcategories' => function ($query) {
            $query->where('status', true);
        }])->get();

        // Initialize the product query
        $query = Product::where('status', 'active')
            ->with(['category', 'subcategory', 'images' => function ($query) {
                $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc'); // Fetch primary image first
            }]);

        $category = null;

        // Filter products based on slug (category or subcategory)
        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            } else {
                $subcategory = Subcategory::where('slug', $slug)->first();
                if ($subcategory) {
                    $query->where('subcategory_id', $subcategory->id);
                    $category = $subcategory->category; // For breadcrumb
                }
            }
        } else {
            $category = 'All Products'; // Default category when no slug
        }

        // Search filter
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Price filtering
        if ($request->has('filter.v.price.gte') && is_numeric($request->input('filter.v.price.gte'))) {
            $query->where('price', '>=', $request->input('filter.v.price.gte'));
        }
        if ($request->has('filter.v.price.lte') && is_numeric($request->input('filter.v.price.lte'))) {
            $query->where('price', '<=', $request->input('filter.v.price.lte'));
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'popularity':
                $query->orderBy('sold_count', 'desc'); // Assumes sold_count column exists
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc'); // Assumes average_rating column exists
                break;
            case 'newness':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Default to latest
        }

        // Paginate results (12 products per page)
        $products = $query->paginate(12)->through(function ($product) {
            $primaryImage = $product->images->first();
            $secondaryImage = $product->images->skip(1)->first() ?? $primaryImage; // Fallback to primary if no secondary
            return [
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price, // Use sale_price if available
                'old_price' => $product->sale_price && $product->sale_price < $product->price ? $product->price : null,
                'image_primary' => $primaryImage ? asset('storage/' . $primaryImage->image) : asset('assets/images/product/placeholder.jpg'),
                'image_secondary' => $secondaryImage ? asset('storage/' . $secondaryImage->image) : asset('assets/images/product/placeholder.jpg'),
                'on_sale' => !is_null($product->sale_price) && $product->sale_price < $product->price,
                'category_slug' => $product->category ? $product->category->slug : null,
                'subcategory_slug' => $product->subcategory ? $product->subcategory->slug : null,
            ];
        });

        return view('store.pages.shop', compact('products', 'category', 'categories'));
    }
}
