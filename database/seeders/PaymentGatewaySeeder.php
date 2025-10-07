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
                'name' => 'Stripe',
                'gateway_key' => 'stripe',
                'api_key' => '',
                'api_secret' => '',
                'status' => false,
                'config' => json_encode([
                    'publishable_key' => '',
                    'currency' => 'usd',
                    'description' => 'Credit card payment via Stripe',
                ]),
            ],
            [
                'name' => 'PayPal',
                'gateway_key' => 'paypal',
                'api_key' => '',
                'api_secret' => '',
                'status' => false,
                'config' => json_encode([
                    'client_id' => '',
                    'mode' => 'sandbox',
                    'currency' => 'usd',
                    'description' => 'PayPal payment gateway',
                ]),
            ],
            [
                'name' => 'Razorpay',
                'gateway_key' => 'razorpay',
                'api_key' => '',
                'api_secret' => '',
                'status' => false,
                'config' => json_encode([
                    'key_id' => '',
                    'key_secret' => '',
                    'currency' => 'INR',
                    'description' => 'Razorpay payment gateway for India',
                ]),
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
