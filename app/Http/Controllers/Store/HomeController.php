<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Slider;

class HomeController extends Controller
{
public function index()
    {
        $categories = Category::where('status', true)
            ->with(['subcategories' => function ($query) {
                $query->where('status', true);
            }])
            ->get();

        // Fetch active sliders ordered by 'order' column
        $sliders = Slider::where('status', 1)->orderBy('order', 'asc')->get();

        // Example: Fetch latest products (replace with actual Product model query)
        $products = [
            [
                'slug' => 'rhysley-rayon-red-kurti',
                'name' => 'Rhysley Rayon Red Kurti',
                'price' => 1840.00,
                'old_price' => 2300.00,
                'image_primary' => 'assets/images/product/p1.jpg',
                'image_secondary' => 'assets/images/product/p2.jpg',
                'on_sale' => true,
            ],
            [
                'slug' => 'printed-kurta-with-pant',
                'name' => 'Printed Kurta with Pant & Dupatta',
                'price' => 1200.00,
                'old_price' => 2000.00,
                'image_primary' => 'assets/images/product/p7.jpg',
                'image_secondary' => 'assets/images/product/p8.jpg',
                'on_sale' => true,
            ],
            [
                'slug' => 'casual-short-sleeve-top',
                'name' => 'Casual Short Sleeve Loose Fit Top',
                'price' => 2200.00,
                'old_price' => 2500.00,
                'image_primary' => 'assets/images/product/p10.jpg',
                'image_secondary' => 'assets/images/product/p9.jpg',
                'on_sale' => true,
            ],
            [
                'slug' => 'casual-formal-blazer',
                'name' => 'Casual Formal Blazer for Women',
                'price' => 2200.00,
                'image_primary' => 'assets/images/product/p14.jpg',
                'image_secondary' => 'assets/images/product/p13.jpg',
                'on_sale' => false,
            ],
        ];

        // Pass data to the view
        return view('store.pages.home', compact('categories', 'products', 'sliders'));
    }
}
