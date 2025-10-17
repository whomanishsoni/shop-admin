<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Slider;
use App\Models\Product;
use App\Models\BlogPost;
use Illuminate\Support\Str; // Import the Str facade

class HomeController extends Controller
{
    // public function index()
    // {
    //     // Fetch active categories with active subcategories
    //     $categories = Category::where('status', true)
    //         ->with(['subcategories' => function ($query) {
    //             $query->where('status', true);
    //         }])
    //         ->get();

    //     // Fetch active sliders ordered by 'order' column
    //     $sliders = Slider::where('status', 1)->orderBy('order', 'asc')->get();

    //     // Fetch the latest 8 active products with images
    //     $products = Product::where('status', 'active')
    //         ->with(['images' => function ($query) {
    //             $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
    //         }])
    //         ->orderBy('created_at', 'desc')
    //         ->take(8)
    //         ->get()
    //         ->map(function ($product) {
    //             $primaryImage = $product->images->first();
    //             $secondaryImage = $product->images->skip(1)->first() ?? $primaryImage;
    //             return [
    //                 'slug' => $product->slug,
    //                 'name' => $product->name,
    //                 'price' => $product->sale_price ?? $product->price,
    //                 'old_price' => $product->sale_price && $product->sale_price < $product->price ? $product->price : null,
    //                 'image_primary' => $primaryImage ? 'storage/' . $primaryImage->image : 'assets/images/product/placeholder.jpg',
    //                 'image_secondary' => $secondaryImage ? 'storage/' . $secondaryImage->image : ($primaryImage ? 'storage/' . $primaryImage->image : 'assets/images/product/placeholder.jpg'),
    //                 'on_sale' => !is_null($product->sale_price) && $product->sale_price < $product->price,
    //                 'product_url' => route('product.detail', $product->slug),
    //             ];
    //         });

    //     // Log products for debugging
    //     \Log::info('Latest Products: ', $products->toArray());

    //     // Pass data to the view
    //     return view('store.pages.home', compact('categories', 'products', 'sliders'));
    // }

public function index()
    {
        // Fetch active categories with active subcategories
        $categories = Category::where('status', true)
            ->with(['subcategories' => function ($query) {
                $query->where('status', true);
            }])
            ->get();

        // Fetch active sliders ordered by 'order' column
        $sliders = Slider::where('status', 1)->orderBy('order', 'asc')->get();

        // Fetch the latest 8 active products with images
        $products = Product::where('status', 'active')
            ->with(['images' => function ($query) {
                $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
            }])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(function ($product) {
                $primaryImage = $product->images->first();
                $secondaryImage = $product->images->skip(1)->first() ?? $primaryImage;
                return [
                    'slug' => $product->slug,
                    'name' => $product->name,
                    'price' => $product->sale_price ?? $product->price,
                    'old_price' => $product->sale_price && $product->sale_price < $product->price ? $product->price : null,
                    'image_primary' => $primaryImage ? 'storage/' . $primaryImage->image : 'assets/images/product/placeholder.jpg',
                    'image_secondary' => $secondaryImage ? 'storage/' . $secondaryImage->image : ($primaryImage ? 'storage/' . $primaryImage->image : 'assets/images/product/placeholder.jpg'),
                    'on_sale' => !is_null($product->sale_price) && $product->sale_price < $product->price,
                    'product_url' => route('product.detail', $product->slug),
                ];
            });

        // Fetch the latest 5 published blog posts for the slider
        $blogPosts = BlogPost::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($post) {
                return [
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content' => Str::limit(strip_tags($post->content), 100),
                    'featured_image' => $post->featured_image ? 'storage/' . $post->featured_image : 'assets/images/blog/placeholder.jpg',
                    'created_at' => $post->created_at->format('F d, Y'),
                    'url' => route('blog.show', $post->slug),
                ];
            });

        return view('store.pages.home', compact('categories', 'products', 'sliders', 'blogPosts'));
    }
}
