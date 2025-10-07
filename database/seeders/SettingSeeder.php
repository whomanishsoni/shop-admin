<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'My E-Commerce Store', 'type' => 'text'],
            ['key' => 'site_tagline', 'value' => 'Your One-Stop Shop', 'type' => 'text'],
            ['key' => 'site_email', 'value' => 'info@example.com', 'type' => 'text'],
            ['key' => 'site_phone', 'value' => '+91 1234567890', 'type' => 'text'],
            ['key' => 'site_address', 'value' => '123 Main Street, New Delhi, India', 'type' => 'textarea'],
            ['key' => 'site_logo', 'value' => '', 'type' => 'image'],
            ['key' => 'site_favicon', 'value' => '', 'type' => 'image'],
            ['key' => 'footer_logo', 'value' => '', 'type' => 'image'],
            ['key' => 'footer_text', 'value' => '© 2025 My E-Commerce Store. All rights reserved.', 'type' => 'textarea'],
            
            ['key' => 'facebook_url', 'value' => '', 'type' => 'text'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'text'],
            ['key' => 'youtube_url', 'value' => '', 'type' => 'text'],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'text'],
            ['key' => 'pinterest_url', 'value' => '', 'type' => 'text'],
            
            ['key' => 'smtp_host', 'value' => 'smtp.gmail.com', 'type' => 'text'],
            ['key' => 'smtp_port', 'value' => '587', 'type' => 'text'],
            ['key' => 'smtp_username', 'value' => '', 'type' => 'text'],
            ['key' => 'smtp_password', 'value' => '', 'type' => 'text'],
            ['key' => 'smtp_encryption', 'value' => 'tls', 'type' => 'text'],
            ['key' => 'mail_from_address', 'value' => 'noreply@example.com', 'type' => 'text'],
            ['key' => 'mail_from_name', 'value' => 'My E-Commerce Store', 'type' => 'text'],
            
            ['key' => 'meta_title', 'value' => 'My E-Commerce Store - Best Online Shopping', 'type' => 'text'],
            ['key' => 'meta_description', 'value' => 'Shop the latest products at great prices. Fast shipping across India.', 'type' => 'textarea'],
            ['key' => 'meta_keywords', 'value' => 'ecommerce, online shopping, india, products', 'type' => 'text'],
            
            ['key' => 'currency_symbol', 'value' => '₹', 'type' => 'text'],
            ['key' => 'currency_position', 'value' => 'left', 'type' => 'text'],
            ['key' => 'tax_enabled', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'tax_rate', 'value' => '18', 'type' => 'number'],
            
            ['key' => 'min_order_amount', 'value' => '0', 'type' => 'number'],
            ['key' => 'free_shipping_threshold', 'value' => '500', 'type' => 'number'],
            
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text'],
            ['key' => 'facebook_pixel_id', 'value' => '', 'type' => 'text'],
            
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean'],
            ['key' => 'maintenance_message', 'value' => 'We are currently undergoing maintenance. Please check back soon.', 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
