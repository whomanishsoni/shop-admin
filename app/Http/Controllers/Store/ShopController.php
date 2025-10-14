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

        // Price filtering
        if ($request->has('filter.v.price.gte') && is_numeric($request->input('filter.v.price.gte'))) {
            $query->where('price', '>=', $request->input('filter.v.price.gte'));
        }
        if ($request->has('filter.v.price.lte') && is_numeric($request->input('filter.v.price.lte'))) {
            $query->where('price', '<=', $request->input('filter.v.price.lte'));
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

    public function quickView($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['images' => function ($query) {
                $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
            }, 'attributeValues.attribute'])
            ->firstOrFail();

        $images = $product->images->map(function ($image) {
            return asset('storage/' . $image->image);
        })->toArray();

        // Extract sizes and colors from attributeValues
        $sizes = $product->attributeValues
            ->where('attribute.name', 'Size')
            ->flatMap(function ($value) {
                $decodedValue = is_array($value->value) ? $value->value : (json_decode($value->value, true) ?: [$value->value]);
                return $decodedValue;
            })
            ->unique()
            ->values()
            ->toArray();

        $colors = $product->attributeValues
            ->where('attribute.name', 'Color')
            ->flatMap(function ($value) {
                $decodedValue = is_array($value->value) ? $value->value : (json_decode($value->value, true) ?: [$value->value]);
                return $decodedValue;
            })
            ->unique()
            ->values()
            ->toArray();

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => floatval($product->sale_price ?? $product->price),
            'old_price' => $product->sale_price && $product->sale_price < $product->price ? floatval($product->price) : null,
            'description' => $product->description,
            'images' => $images,
            'sizes' => $sizes,
            'colors' => $colors,
            'average_rating' => $product->reviews->avg('rating') ?? 0,
            'review_count' => $product->reviews->count(),
        ]);
    }
}
