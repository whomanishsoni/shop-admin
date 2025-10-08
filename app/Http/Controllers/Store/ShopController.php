<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index()
    {
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
            [
                'slug' => 'rayon-viscose-anarkali',
                'name' => 'Women\'s Rayon Viscose Anarkali Printed Kurta',
                'price' => 1500.00,
                'old_price' => 2000.00,
                'image_primary' => 'assets/images/product/p16.jpg',
                'image_secondary' => 'assets/images/product/p17.jpg',
                'on_sale' => true,
            ],
            // Additional products reusing the same images (cycling through existing ones)
            [
                'slug' => 'elegant-silk-saree',
                'name' => 'Elegant Silk Saree with Blouse',
                'price' => 3200.00,
                'old_price' => 4000.00,
                'image_primary' => 'assets/images/product/p1.jpg', // Reusing p1.jpg
                'image_secondary' => 'assets/images/product/p2.jpg', // Reusing p2.jpg
                'on_sale' => true,
            ],
            [
                'slug' => 'floral-printed-lehenga',
                'name' => 'Floral Printed Lehenga Choli',
                'price' => 4500.00,
                'old_price' => 5500.00,
                'image_primary' => 'assets/images/product/p7.jpg', // Reusing p7.jpg
                'image_secondary' => 'assets/images/product/p8.jpg', // Reusing p8.jpg
                'on_sale' => false,
            ],
            [
                'slug' => 'cotton-ethnic-kurta',
                'name' => 'Cotton Ethnic Straight Kurta',
                'price' => 950.00,
                'old_price' => 1200.00,
                'image_primary' => 'assets/images/product/p10.jpg', // Reusing p10.jpg
                'image_secondary' => 'assets/images/product/p9.jpg', // Reusing p9.jpg
                'on_sale' => true,
            ],
            [
                'slug' => 'designer-gown',
                'name' => 'Designer Embroidered Gown',
                'price' => 2800.00,
                'image_primary' => 'assets/images/product/p14.jpg', // Reusing p14.jpg
                'image_secondary' => 'assets/images/product/p13.jpg', // Reusing p13.jpg
                'on_sale' => true,
            ],
            [
                'slug' => 'viscose-palazzo-set',
                'name' => 'Viscose Printed Palazzo Set',
                'price' => 1750.00,
                'old_price' => 2200.00,
                'image_primary' => 'assets/images/product/p16.jpg', // Reusing p16.jpg
                'image_secondary' => 'assets/images/product/p17.jpg', // Reusing p17.jpg
                'on_sale' => true,
            ],
            [
                'slug' => 'summer-tshirt-pack',
                'name' => 'Summer Casual T-Shirt Pack (3 Pcs)',
                'price' => 750.00,
                'old_price' => 1000.00,
                'image_primary' => 'assets/images/product/p1.jpg', // Reusing p1.jpg again
                'image_secondary' => 'assets/images/product/p2.jpg', // Reusing p2.jpg again
                'on_sale' => false,
            ],
            [
                'slug' => 'chiffon-dupatta-set',
                'name' => 'Chiffon Dupatta with Kurta Set',
                'price' => 2100.00,
                'image_primary' => 'assets/images/product/p7.jpg', // Reusing p7.jpg again
                'image_secondary' => 'assets/images/product/p8.jpg', // Reusing p8.jpg again
                'on_sale' => true,
            ],
        ];
        $category = 'Suits'; // Static category
        return view('store.pages.shop', compact('products', 'category'));
    }
}
