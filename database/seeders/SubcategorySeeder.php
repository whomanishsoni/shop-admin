<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::where('slug', 'shop-by-category')->first();

        if (!$category) {
            return; // Skip if category doesn't exist
        }

        $subcategories = [
            [
                'category_id' => $category->id,
                'name' => 'Kaftan Sets',
                'slug' => 'kaftan-sets',
                'description' => 'Elegant kaftan sets perfect for casual and semi-formal occasions',
                'image' => null,
                'sort_order' => 1,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Lehenga Sets',
                'slug' => 'lehenga-sets',
                'description' => 'Traditional lehenga sets for weddings and festive celebrations',
                'image' => null,
                'sort_order' => 2,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Saree Sets',
                'slug' => 'saree-sets',
                'description' => 'Beautiful saree sets with matching blouses and accessories',
                'image' => null,
                'sort_order' => 3,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Anarkali Sets',
                'slug' => 'anarkali-sets',
                'description' => 'Graceful Anarkali suits with intricate embroidery work',
                'image' => null,
                'sort_order' => 4,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Sharara Sets',
                'slug' => 'sharara-sets',
                'description' => 'Flowing sharara sets with elegant designs and comfort',
                'image' => null,
                'sort_order' => 5,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Jacket Sets',
                'slug' => 'jacket-sets',
                'description' => 'Stylish jacket sets combining tradition with modern fashion',
                'image' => null,
                'sort_order' => 6,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Kurta Sets',
                'slug' => 'kurta-sets',
                'description' => 'Comfortable kurta sets for everyday wear and occasions',
                'image' => null,
                'sort_order' => 7,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Palazzo Sets',
                'slug' => 'palazzo-sets',
                'description' => 'Modern palazzo sets with contemporary designs',
                'image' => null,
                'sort_order' => 8,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Co-ord Sets',
                'slug' => 'co-ord-sets',
                'description' => 'Matching co-ordinated sets for perfect styling',
                'image' => null,
                'sort_order' => 9,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Dresses',
                'slug' => 'dresses',
                'description' => 'Elegant dresses for various occasions and events',
                'image' => null,
                'sort_order' => 10,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Gowns',
                'slug' => 'gowns',
                'description' => 'Luxurious gowns for special occasions and celebrations',
                'image' => null,
                'sort_order' => 11,
                'status' => 1,
            ],
            [
                'category_id' => $category->id,
                'name' => 'Jumpsuits',
                'slug' => 'jumpsuits',
                'description' => 'Stylish jumpsuits combining comfort and fashion',
                'image' => null,
                'sort_order' => 12,
                'status' => 1,
            ],
        ];

        foreach ($subcategories as $subcategory) {
            Subcategory::create($subcategory);
        }
    }
}
