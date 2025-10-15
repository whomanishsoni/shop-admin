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
            [
                'name' => 'Cash on Delivery',
                'gateway_key' => 'cod',
                'api_key' => '',
                'api_secret' => '',
                'status' => true,
                'config' => json_encode([
                    'description' => 'Pay when you receive the order',
                    'instructions' => 'Please have exact amount ready for delivery',
                    'additional_fee' => 0,
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
