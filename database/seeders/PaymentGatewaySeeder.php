<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'Razorpay',
                'gateway_key' => 'razorpay',
                'mode' => 'test',
                'test_key_id' => 'rzp_test_Rf8hHEs6KqmbN9',
                'test_key_secret' => 'FSbOjp2Wzrk9Az0JSdMnpbMI',
                'live_key_id' => '',
                'live_key_secret' => '',
                'status' => true,
            ],
            [
                'name' => 'Cash on Delivery',
                'gateway_key' => 'cod',
                'mode' => null,
                'test_key_id' => null,
                'test_key_secret' => null,
                'live_key_id' => null,
                'live_key_secret' => null,
                'status' => true,
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::updateOrCreate(
                ['gateway_key' => $gateway['gateway_key']],
                $gateway
            );
        }
    }
}
