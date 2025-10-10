<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingMethod;
use App\Models\ShippingZone;

class ShippingSeeder extends Seeder
{
    protected $stateCodes = [
        'Andaman and Nicobar Islands' => 'AN',
        'Andhra Pradesh' => 'AP',
        'Arunachal Pradesh' => 'AR',
        'Assam' => 'AS',
        'Bihar' => 'BR',
        'Chandigarh' => 'CH',
        'Chhattisgarh' => 'CT',
        'Delhi' => 'DL',
        'Dadra and Nagar Haveli and Daman and Diu' => 'DN',
        'Daman and Diu' => 'DN',
        'Dadra and Nagar Haveli' => 'DN',
        'Goa' => 'GA',
        'Gujarat' => 'GJ',
        'Himachal Pradesh' => 'HP',
        'Haryana' => 'HR',
        'Jharkhand' => 'JH',
        'Jammu and Kashmir' => 'JK',
        'Karnataka' => 'KA',
        'Kerala' => 'KL',
        'Ladakh' => 'LA',
        'Lakshadweep' => 'LD',
        'Maharashtra' => 'MH',
        'Meghalaya' => 'ML',
        'Manipur' => 'MN',
        'Madhya Pradesh' => 'MP',
        'Mizoram' => 'MZ',
        'Nagaland' => 'NL',
        'Odisha' => 'OR',
        'Punjab' => 'PB',
        'Puducherry' => 'PY',
        'Rajasthan' => 'RJ',
        'Sikkim' => 'SK',
        'Tamil Nadu' => 'TN',
        'Telangana' => 'TG',
        'Tripura' => 'TR',
        'Uttar Pradesh' => 'UP',
        'Uttarakhand' => 'UT',
        'West Bengal' => 'WB',
    ];

    public function run(): void
    {
        $methods = [
            [
                'name' => 'Standard Shipping',
                'description' => 'Delivery within 5-7 business days',
                'cost' => 0.00,
                'delivery_time' => 7,
                'status' => true,
            ],
            [
                'name' => 'Express Shipping',
                'description' => 'Delivery within 2-3 business days',
                'cost' => 150.00,
                'delivery_time' => 3,
                'status' => true,
            ],
            [
                'name' => 'Same Day Delivery',
                'description' => 'Delivery on the same day for metro cities',
                'cost' => 250.00,
                'delivery_time' => 1,
                'status' => true,
            ],
        ];

        foreach ($methods as $methodData) {
            ShippingMethod::updateOrCreate(
                ['name' => $methodData['name']],
                $methodData
            );
        }

        $indiaStates = [
            'North Zone' => ['DL', 'HR', 'PB', 'HP', 'JK', 'UT', 'CH'],
            'South Zone' => ['AP', 'KA', 'KL', 'TN', 'TG', 'PY', 'LD'],
            'East Zone' => ['BR', 'JH', 'OR', 'WB', 'AN'],
            'West Zone' => ['GA', 'GJ', 'MH', 'RJ', 'DN'],
            'Central Zone' => ['CT', 'MP', 'UP'],
            'North East Zone' => ['AR', 'AS', 'MN', 'ML', 'MZ', 'NL', 'SK', 'TR'],
        ];

        $standardMethod = ShippingMethod::where('name', 'Standard Shipping')->first();
        $expressMethod = ShippingMethod::where('name', 'Express Shipping')->first();

        if ($standardMethod) {
            foreach ($indiaStates as $zoneName => $stateCodes) {
                ShippingZone::updateOrCreate(
                    [
                        'name' => $zoneName,
                        'shipping_method_id' => $standardMethod->id
                    ],
                    [
                        'states' => json_encode($stateCodes),
                        'rate' => $zoneName === 'North East Zone' ? 100.00 : 0.00,
                        'status' => true,
                    ]
                );
            }
        }

        if ($expressMethod) {
            foreach ($indiaStates as $zoneName => $stateCodes) {
                $expressZoneName = $zoneName . ' - Express';
                $rate = match($zoneName) {
                    'North East Zone' => 300.00,
                    'South Zone' => 200.00,
                    default => 150.00,
                };

                ShippingZone::updateOrCreate(
                    [
                        'name' => $expressZoneName,
                        'shipping_method_id' => $expressMethod->id
                    ],
                    [
                        'states' => json_encode($stateCodes),
                        'rate' => $rate,
                        'status' => true,
                    ]
                );
            }
        }
    }
}
