<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Welcome Email',
                'subject' => 'Welcome to {{site_name}}!',
                'body' => '<h1>Welcome {{user_name}}!</h1><p>Thank you for registering at {{site_name}}. We are excited to have you on board.</p><p>Best regards,<br>{{site_name}} Team</p>',
                'variables' => json_encode(['{{user_name}}', '{{user_email}}', '{{site_name}}', '{{site_url}}']),
                'status' => true,
            ],
            [
                'name' => 'Forgot Password',
                'subject' => 'Reset Your Password - {{site_name}}',
                'body' => '<h1>Password Reset Request</h1><p>Hi {{user_name}},</p><p>You have requested to reset your password. Click the link below to reset:</p><p><a href="{{reset_link}}">Reset Password</a></p><p>This link will expire in 60 minutes.</p><p>If you did not request this, please ignore this email.</p><p>Best regards,<br>{{site_name}} Team</p>',
                'variables' => json_encode(['{{user_name}}', '{{user_email}}', '{{reset_link}}', '{{site_name}}']),
                'status' => true,
            ],
            [
                'name' => 'Order Confirmation',
                'subject' => 'Order Confirmation #{{order_number}} - {{site_name}}',
                'body' => '<h1>Thank you for your order!</h1><p>Hi {{customer_name}},</p><p>Your order #{{order_number}} has been confirmed and is being processed.</p><h3>Order Details:</h3><p>Order Number: {{order_number}}<br>Order Total: {{order_total}}<br>Payment Method: {{payment_method}}<br>Shipping Address: {{shipping_address}}</p><p>You can track your order status from your account dashboard.</p><p>Best regards,<br>{{site_name}} Team</p>',
                'variables' => json_encode(['{{customer_name}}', '{{order_number}}', '{{order_total}}', '{{payment_method}}', '{{shipping_address}}', '{{site_name}}']),
                'status' => true,
            ],
            [
                'name' => 'Order Shipped',
                'subject' => 'Your Order #{{order_number}} Has Been Shipped',
                'body' => '<h1>Your order is on the way!</h1><p>Hi {{customer_name}},</p><p>Great news! Your order #{{order_number}} has been shipped and is on its way to you.</p><h3>Shipping Details:</h3><p>Tracking Number: {{tracking_number}}<br>Carrier: {{carrier_name}}<br>Estimated Delivery: {{estimated_delivery}}</p><p>You can track your package using the tracking number above.</p><p>Best regards,<br>{{site_name}} Team</p>',
                'variables' => json_encode(['{{customer_name}}', '{{order_number}}', '{{tracking_number}}', '{{carrier_name}}', '{{estimated_delivery}}', '{{site_name}}']),
                'status' => true,
            ],
            [
                'name' => 'Order Delivered',
                'subject' => 'Your Order #{{order_number}} Has Been Delivered',
                'body' => '<h1>Order Delivered Successfully!</h1><p>Hi {{customer_name}},</p><p>Your order #{{order_number}} has been delivered successfully.</p><p>We hope you love your purchase! If you have any questions or concerns, please don\'t hesitate to contact us.</p><p>Please take a moment to leave a review of your products.</p><p>Thank you for shopping with us!</p><p>Best regards,<br>{{site_name}} Team</p>',
                'variables' => json_encode(['{{customer_name}}', '{{order_number}}', '{{site_name}}']),
                'status' => true,
            ],
            [
                'name' => 'Order Cancelled',
                'subject' => 'Order #{{order_number}} Cancelled - {{site_name}}',
                'body' => '<h1>Order Cancelled</h1><p>Hi {{customer_name}},</p><p>Your order #{{order_number}} has been cancelled as per your request.</p><h3>Cancellation Details:</h3><p>Order Number: {{order_number}}<br>Cancellation Reason: {{cancellation_reason}}<br>Refund Status: {{refund_status}}</p><p>If you paid online, your refund will be processed within 5-7 business days.</p><p>If you have any questions, please contact our support team.</p><p>Best regards,<br>{{site_name}} Team</p>',
                'variables' => json_encode(['{{customer_name}}', '{{order_number}}', '{{cancellation_reason}}', '{{refund_status}}', '{{site_name}}']),
                'status' => true,
            ],
            [
                'name' => 'New Customer Registration',
                'subject' => 'Verify Your Email - {{site_name}}',
                'body' => '<h1>Welcome to {{site_name}}!</h1><p>Hi {{user_name}},</p><p>Thank you for registering with us. Please verify your email address by clicking the link below:</p><p><a href="{{verification_link}}">Verify Email Address</a></p><p>This link will expire in 24 hours.</p><p>If you did not create an account, please ignore this email.</p><p>Best regards,<br>{{site_name}} Team</p>',
                'variables' => json_encode(['{{user_name}}', '{{user_email}}', '{{verification_link}}', '{{site_name}}']),
                'status' => true,
            ],
            [
                'name' => 'Low Stock Alert',
                'subject' => 'Low Stock Alert - {{product_name}}',
                'body' => '<h1>Low Stock Alert</h1><p>Hello Admin,</p><p>The following product is running low on stock:</p><p>Product: {{product_name}}<br>SKU: {{product_sku}}<br>Current Stock: {{current_stock}}<br>Threshold: {{threshold}}</p><p>Please restock soon to avoid going out of stock.</p>',
                'variables' => json_encode(['{{product_name}}', '{{product_sku}}', '{{current_stock}}', '{{threshold}}']),
                'status' => true,
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['name' => $template['name']],
                $template
            );
        }
    }
}
