<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingMethod;
use App\Models\ShippingZone;

class ShippingSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Standard Shipping',
                'description' => 'Delivery within 5-7 business days',
                'cost' => 0,
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
            'North Zone' => ['Delhi', 'Haryana', 'Punjab', 'Himachal Pradesh', 'Jammu and Kashmir', 'Uttarakhand', 'Chandigarh'],
            'South Zone' => ['Andhra Pradesh', 'Karnataka', 'Kerala', 'Tamil Nadu', 'Telangana', 'Puducherry', 'Lakshadweep'],
            'East Zone' => ['Bihar', 'Jharkhand', 'Odisha', 'West Bengal', 'Andaman and Nicobar Islands'],
            'West Zone' => ['Goa', 'Gujarat', 'Maharashtra', 'Rajasthan', 'Daman and Diu', 'Dadra and Nagar Haveli'],
            'Central Zone' => ['Chhattisgarh', 'Madhya Pradesh', 'Uttar Pradesh'],
            'North East Zone' => ['Arunachal Pradesh', 'Assam', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Sikkim', 'Tripura'],
        ];

        $standardMethod = ShippingMethod::where('name', 'Standard Shipping')->first();
        $expressMethod = ShippingMethod::where('name', 'Express Shipping')->first();

        if ($standardMethod) {
            foreach ($indiaStates as $zoneName => $states) {
                ShippingZone::updateOrCreate(
                    [
                        'name' => $zoneName,
                        'shipping_method_id' => $standardMethod->id
                    ],
                    [
                        'states' => json_encode($states),
                        'rate' => $zoneName === 'North East Zone' ? 100.00 : 0,
                        'status' => true,
                    ]
                );
            }
        }

        if ($expressMethod) {
            foreach ($indiaStates as $zoneName => $states) {
                $rate = match($zoneName) {
                    'North East Zone' => 300.00,
                    'South Zone' => 200.00,
                    default => 150.00,
                };
                
                ShippingZone::updateOrCreate(
                    [
                        'name' => $zoneName . ' - Express',
                        'shipping_method_id' => $expressMethod->id
                    ],
                    [
                        'states' => json_encode($states),
                        'rate' => $rate,
                        'status' => true,
                    ]
                );
            }
        }
    }
}
