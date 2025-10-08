<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function show($slug)
    {
        $products = [
            ['slug' => 'rhysley-rayon-red-kurti', 'name' => 'Rhysley Rayon Red Kurti', 'price' => 1840.00, 'old_price' => 2300.00, 'image_primary' => 'assets/images/product/p1.jpg', 'image_secondary' => 'assets/images/product/p2.jpg', 'on_sale' => true],
            ['slug' => 'printed-kurta-with-pant', 'name' => 'Printed Kurta with Pant & Dupatta', 'price' => 1200.00, 'old_price' => 2000.00, 'image_primary' => 'assets/images/product/p7.jpg', 'image_secondary' => 'assets/images/product/p8.jpg', 'on_sale' => true],
            ['slug' => 'casual-short-sleeve-top', 'name' => 'Casual Short Sleeve Loose Fit Top', 'price' => 2200.00, 'old_price' => 2500.00, 'image_primary' => 'assets/images/product/p10.jpg', 'image_secondary' => 'assets/images/product/p9.jpg', 'on_sale' => true],
            ['slug' => 'casual-formal-blazer', 'name' => 'Casual Formal Blazer for Women', 'price' => 2200.00, 'image_primary' => 'assets/images/product/p14.jpg', 'image_secondary' => 'assets/images/product/p13.jpg', 'on_sale' => false],
            ['slug' => 'rayon-viscose-anarkali', 'name' => 'Women\'s Rayon Viscose Anarkali Printed Kurta', 'price' => 1500.00, 'old_price' => 2000.00, 'image_primary' => 'assets/images/product/p16.jpg', 'image_secondary' => 'assets/images/product/p17.jpg', 'on_sale' => true],
        ];
        $product = collect($products)->firstWhere('slug', $slug) ?: [];
        return view('store.pages.product-detail', compact('product'));
    }
}
