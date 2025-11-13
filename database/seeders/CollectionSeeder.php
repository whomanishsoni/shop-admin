<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Collection;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = [
            [
                'name' => 'Raagmayi',
                'slug' => 'raagmayi',
                'description' => 'Elegant and graceful collection inspired by traditional melodies',
                'sort_order' => 1,
                'status' => 1,
            ],
            [
                'name' => 'Jashn De Fleurs',
                'slug' => 'jashn-de-fleurs',
                'description' => 'Celebration of flowers in exquisite designs and craftsmanship',
                'sort_order' => 2,
                'status' => 1,
            ],
            [
                'name' => 'Swarniraha',
                'slug' => 'swarniraha',
                'description' => 'Golden radiance collection with luxurious and shimmering designs',
                'sort_order' => 3,
                'status' => 1,
            ],
            [
                'name' => 'Tarang',
                'slug' => 'tarang',
                'description' => 'Flowing waves of elegance in contemporary fashion',
                'sort_order' => 4,
                'status' => 1,
            ],
            [
                'name' => 'Fleur',
                'slug' => 'fleur',
                'description' => 'Delicate floral inspirations brought to life in stunning garments',
                'sort_order' => 5,
                'status' => 1,
            ],
            [
                'name' => 'Zaria',
                'slug' => 'zaria',
                'description' => 'Radiant and bold collection for the modern woman',
                'sort_order' => 6,
                'status' => 1,
            ],
            [
                'name' => 'Avanya',
                'slug' => 'avanya',
                'description' => 'Timeless beauty and sophistication in every piece',
                'sort_order' => 7,
                'status' => 1,
            ],
            [
                'name' => 'Ogha',
                'slug' => 'ogha',
                'description' => 'Mystical and enchanting designs with intricate detailing',
                'sort_order' => 8,
                'status' => 1,
            ],
        ];

        foreach ($collections as $collection) {
            Collection::create($collection);
        }
    }
}
