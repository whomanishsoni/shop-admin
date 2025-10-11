<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;

class ShopController extends Controller
{
    public function index($slug = null)
    {
        // Fetch all active categories and subcategories
        $categories = Category::where('status', true)->with(['subcategories' => function ($query) {
            $query->where('status', true);
        }])->get();

        // Hardcoded products (replace with database query in production)
        $allProducts = [
            [
                'slug' => 'rhysley-rayon-red-kurti',
                'name' => 'Rhysley Rayon Red Kurti',
                'price' => 1840.00,
                'old_price' => 2300.00,
                'image_primary' => 'assets/images/product/p1.jpg',
                'image_secondary' => 'assets/images/product/p2.jpg',
                'on_sale' => true,
                'category_slug' => 'kurti', // Simulated category slug
                'subcategory_slug' => null,
            ],
            [
                'slug' => 'printed-kurta-with-pant',
                'name' => 'Printed Kurta with Pant & Dupatta',
                'price' => 1200.00,
                'old_price' => 2000.00,
                'image_primary' => 'assets/images/product/p7.jpg',
                'image_secondary' => 'assets/images/product/p8.jpg',
                'on_sale' => true,
                'category_slug' => 'suits', // Simulated category slug
                'subcategory_slug' => null,
            ],
            [
                'slug' => 'casual-short-sleeve-top',
                'name' => 'Casual Short Sleeve Loose Fit Top',
                'price' => 2200.00,
                'old_price' => 2500.00,
                'image_primary' => 'assets/images/product/p10.jpg',
                'image_secondary' => 'assets/images/product/p9.jpg',
                'on_sale' => true,
                'category_slug' => 'tshirts', // Simulated category slug
                'subcategory_slug' => null,
            ],
            [
                'slug' => 'casual-formal-blazer',
                'name' => 'Casual Formal Blazer for Women',
                'price' => 2200.00,
                'image_primary' => 'assets/images/product/p14.jpg',
                'image_secondary' => 'assets/images/product/p13.jpg',
                'on_sale' => false,
                'category_slug' => 'blazers', // Simulated category slug
                'subcategory_slug' => null,
            ],
            [
                'slug' => 'rayon-viscose-anarkali',
                'name' => 'Women\'s Rayon Viscose Anarkali Printed Kurta',
                'price' => 1500.00,
                'old_price' => 2000.00,
                'image_primary' => 'assets/images/product/p16.jpg',
                'image_secondary' => 'assets/images/product/p17.jpg',
                'on_sale' => true,
                'category_slug' => 'kurti', // Simulated category slug
                'subcategory_slug' => 'anarkali',
            ],
            [
                'slug' => 'elegant-silk-saree',
                'name' => 'Elegant Silk Saree with Blouse',
                'price' => 3200.00,
                'old_price' => 4000.00,
                'image_primary' => 'assets/images/product/p1.jpg',
                'image_secondary' => 'assets/images/product/p2.jpg',
                'on_sale' => true,
                'category_slug' => 'saree', // Simulated category slug
                'subcategory_slug' => null,
            ],
            [
                'slug' => 'floral-printed-lehenga',
                'name' => 'Floral Printed Lehenga Choli',
                'price' => 4500.00,
                'old_price' => 5500.00,
                'image_primary' => 'assets/images/product/p7.jpg',
                'image_secondary' => 'assets/images/product/p8.jpg',
                'on_sale' => false,
                'category_slug' => 'lehenga', // Simulated category slug
                'subcategory_slug' => null,
            ],
            [
                'slug' => 'cotton-ethnic-kurta',
                'name' => 'Cotton Ethnic Straight Kurta',
                'price' => 950.00,
                'old_price' => 1200.00,
                'image_primary' => 'assets/images/product/p10.jpg',
                'image_secondary' => 'assets/images/product/p9.jpg',
                'on_sale' => true,
                'category_slug' => 'kurti', // Simulated category slug
                'subcategory_slug' => 'straight',
            ],
            [
                'slug' => 'designer-gown',
                'name' => 'Designer Embroidered Gown',
                'price' => 2800.00,
                'image_primary' => 'assets/images/product/p14.jpg',
                'image_secondary' => 'assets/images/product/p13.jpg',
                'on_sale' => true,
                'category_slug' => 'gowns', // Simulated category slug
                'subcategory_slug' => null,
            ],
            [
                'slug' => 'viscose-palazzo-set',
                'name' => 'Viscose Printed Palazzo Set',
                'price' => 1750.00,
                'old_price' => 2200.00,
                'image_primary' => 'assets/images/product/p16.jpg',
                'image_secondary' => 'assets/images/product/p17.jpg',
                'on_sale' => true,
                'category_slug' => 'suits', // Simulated category slug
                'subcategory_slug' => 'palazzo',
            ],
            [
                'slug' => 'summer-tshirt-pack',
                'name' => 'Summer Casual T-Shirt Pack (3 Pcs)',
                'price' => 750.00,
                'old_price' => 1000.00,
                'image_primary' => 'assets/images/product/p1.jpg',
                'image_secondary' => 'assets/images/product/p2.jpg',
                'on_sale' => false,
                'category_slug' => 'tshirts', // Simulated category slug
                'subcategory_slug' => null,
            ],
            [
                'slug' => 'chiffon-dupatta-set',
                'name' => 'Chiffon Dupatta with Kurta Set',
                'price' => 2100.00,
                'image_primary' => 'assets/images/product/p7.jpg',
                'image_secondary' => 'assets/images/product/p8.jpg',
                'on_sale' => true,
                'category_slug' => 'suits', // Simulated category slug
                'subcategory_slug' => 'dupatta',
            ],
        ];

        $products = $allProducts;
        $category = null;

        // Filter products based on slug (category or subcategory)
        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $products = array_filter($allProducts, function ($product) use ($category) {
                    return $product['category_slug'] === $category->slug;
                });
            } else {
                $subcategory = Subcategory::where('slug', $slug)->first();
                if ($subcategory) {
                    $products = array_filter($allProducts, function ($product) use ($subcategory) {
                        return $product['subcategory_slug'] === $subcategory->slug;
                    });
                    $category = $subcategory->category;
                }
            }
            $products = array_values($products); // Reindex array after filtering
        } else {
            $category = 'All Products'; // Default category when no slug
        }

        return view('store.pages.shop', compact('products', 'category', 'categories'));
    }
}
