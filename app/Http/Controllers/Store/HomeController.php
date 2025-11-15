<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Collection;
use App\Models\Slider;
use App\Models\Product;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\Video;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch active categories with active subcategories
        $categories = Category::where('status', true)
            ->with(['subcategories' => function ($query) {
                $query->where('status', true);
            }])
            ->get();

        // Fetch active featured collections for shop by collection section
        $collections = Collection::where('status', true)
            ->where('is_featured', true)
            ->whereNotNull('image')
            ->orderBy('is_featured', 'desc')
            ->take(2)
            ->get()
            ->map(function ($collection) {
                return [
                    'name' => $collection->name,
                    'slug' => $collection->slug,
                    'image' => 'storage/' . $collection->image,
                    'url' => route('shop') . '?collection=' . $collection->slug,
                ];
            });

        // Fetch active featured subcategories with images for shop by category section
        $subcategories = Subcategory::where('status', true)
            ->where('is_featured', true)
            ->whereNotNull('image')
            ->with('category')
            ->orderBy('is_featured', 'desc')
            ->take(4)
            ->get()
            ->map(function ($subcategory) {
                return [
                    'name' => $subcategory->name,
                    'slug' => $subcategory->slug,
                    'image' => $subcategory->image ? 'storage/' . $subcategory->image : 'assets/images/subcategory-placeholder.jpg',
                    'url' => route('shop') . '?subcategory=' . $subcategory->slug,
                ];
            });

        // Fetch active sliders ordered by 'order' column
        $sliders = Slider::where('status', 1)->orderBy('sort_order', 'asc')->get();

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

        // Fetch featured products
        $featuredProducts = Product::where('status', 'active')
            ->where('is_featured', true)
            ->with(['images' => function ($query) {
                $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
            }])
            ->orderBy('created_at', 'desc')
            ->take(4)
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

        $testimonials = Testimonial::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($testimonial) {
                return [
                    'name' => $testimonial->name,
                    'designation' => $testimonial->designation ?? 'Customer',
                    'message' => $testimonial->message,
                    'rating' => $testimonial->rating,
                    'image' => $testimonial->image ? 'storage/' . $testimonial->image : 'assets/images/testimonial.png',
                ];
            });

        // Fetch active videos for home page display
        $videos = Video::where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('store.pages.home', compact('categories', 'subcategories', 'products', 'featuredProducts', 'collections', 'sliders', 'blogPosts', 'testimonials', 'videos'));
    }
}
