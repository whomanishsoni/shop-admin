<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    public function run(): void
    {
        $taxes = [
            [
                'name' => 'GST 5%',
                'type' => 'percentage',
                'rate' => 5.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'GST 12%',
                'type' => 'percentage',
                'rate' => 12.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($taxes as $tax) {
            Tax::updateOrCreate(
                ['name' => $tax['name']],
                $tax
            );
        }
    }
}
