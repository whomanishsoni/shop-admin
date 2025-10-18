<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Brand;
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

        // Fetch all active brands (for the sidebar)
        $brands = Brand::where('status', true)->get();

        // Initialize the product query
        $query = Product::where('status', 'active')
            ->with(['category', 'subcategory', 'brand', 'images' => function ($query) {
                $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
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
                    $category = $subcategory->category;
                }
            }
        } else {
            $category = 'All Products';
        }

        // Search filter
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Price filtering with debugging
        $gtePrice = $request->input('filter.v.price.gte');
        $ltePrice = $request->input('filter.v.price.lte');
        if ($gtePrice && is_numeric($gtePrice)) {
            \Log::info("Applying price filter gte: {$gtePrice}");
            $query->where(function ($q) use ($gtePrice) {
                $q->where('price', '>=', floatval($gtePrice))
                  ->orWhere(function ($q2) use ($gtePrice) {
                      $q2->whereNotNull('sale_price')
                         ->where('sale_price', '>=', floatval($gtePrice));
                  });
            });
        }
        if ($ltePrice && is_numeric($ltePrice)) {
            \Log::info("Applying price filter lte: {$ltePrice}");
            $query->where(function ($q) use ($ltePrice) {
                $q->where('price', '<=', floatval($ltePrice))
                  ->orWhere(function ($q2) use ($ltePrice) {
                      $q2->whereNotNull('sale_price')
                         ->where('sale_price', '<=', floatval($ltePrice));
                  });
            });
        }

        // Brand filtering
        if ($request->has('brand')) {
            $selectedBrands = is_array($request->input('brand')) ? $request->input('brand') : (array) $request->input('brand');
            $query->whereIn('brand_id', $selectedBrands);
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'popularity':
                $query->orderBy('sold_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            case 'newness':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Paginate results (12 products per page)
        $products = $query->paginate(12)->through(function ($product) {
            $primaryImage = $product->images->first();
            $secondaryImage = $product->images->skip(1)->first() ?? $primaryImage;
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'old_price' => $product->sale_price && $product->sale_price < $product->price ? $product->price : null,
                'image_primary' => $primaryImage ? asset('storage/' . $primaryImage->image) : asset('assets/images/product/placeholder.jpg'),
                'image_secondary' => $secondaryImage ? asset('storage/' . $secondaryImage->image) : asset('assets/images/product/placeholder.jpg'),
                'on_sale' => !is_null($product->sale_price) && $product->sale_price < $product->price,
                'category_slug' => $product->category ? $product->category->slug : null,
                'subcategory_slug' => $product->subcategory ? $product->subcategory->slug : null,
            ];
        });

        return view('store.pages.shop', compact('products', 'category', 'categories', 'brands'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            })
            ->with(['images' => function ($q) {
                $q->where('is_primary', true)->orderByDesc('is_primary')->limit(1);
            }])
            ->limit(8)
            ->get();

        $suggestions = $products->map(function ($product) {
            $image = $product->images->first();
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->sale_price ?? $product->price,
                'old_price' => $product->sale_price && $product->sale_price < $product->price ? $product->price : null,
                'image' => $image ? asset('storage/' . $image->image) : asset('assets/images/no-image.png'),
                'url' => route('product.detail', $product->slug)
            ];
        });

        return response()->json($suggestions);
    }
}
