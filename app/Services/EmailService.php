<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    protected $settings;

    public function __construct()
    {
        $this->settings = Setting::pluck('value', 'key')->toArray();
    }

    public function sendEmail(string $templateName, string $toEmail, array $variables = [])
    {
        try {
            $template = EmailTemplate::where('name', $templateName)
                ->where('status', true)
                ->first();

            if (!$template) {
                Log::warning("Email template '{$templateName}' not found or inactive");
                return false;
            }

            $defaultVariables = [
                '{{site_name}}' => $this->settings['site_name'] ?? 'E-Commerce Store',
                '{{site_url}}' => url('/'),
                '{{site_email}}' => $this->settings['site_email'] ?? 'info@example.com',
                '{{current_year}}' => date('Y'),
            ];

            $allVariables = array_merge($defaultVariables, $variables);
            
            $subject = $this->replaceVariables($template->subject, $allVariables);
            $body = $this->replaceVariables($template->body, $allVariables);

            $fromEmail = $this->settings['mail_from_address'] ?? env('MAIL_FROM_ADDRESS', 'noreply@example.com');
            $fromName = $this->settings['mail_from_name'] ?? env('MAIL_FROM_NAME', 'E-Commerce Store');

            Mail::send([], [], function ($message) use ($toEmail, $subject, $body, $fromEmail, $fromName) {
                $message->to($toEmail)
                    ->from($fromEmail, $fromName)
                    ->subject($subject)
                    ->html($body);
            });

            Log::info("Email sent successfully", [
                'template' => $templateName,
                'to' => $toEmail,
                'subject' => $subject
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send email: " . $e->getMessage(), [
                'template' => $templateName,
                'to' => $toEmail,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    protected function replaceVariables(string $content, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $content = str_replace($key, $value, $content);
        }
        return $content;
    }

    public function sendWelcomeEmail(string $email, string $userName)
    {
        return $this->sendEmail('Welcome Email', $email, [
            '{{user_name}}' => $userName,
            '{{user_email}}' => $email,
        ]);
    }

    public function sendPasswordResetEmail(string $email, string $userName, string $resetLink)
    {
        return $this->sendEmail('Forgot Password', $email, [
            '{{user_name}}' => $userName,
            '{{user_email}}' => $email,
            '{{reset_link}}' => $resetLink,
        ]);
    }

    public function sendOrderConfirmation(string $email, string $customerName, array $orderDetails)
    {
        return $this->sendEmail('Order Confirmation', $email, array_merge([
            '{{customer_name}}' => $customerName,
        ], $orderDetails));
    }

    public function sendOrderShipped(string $email, string $customerName, array $shippingDetails)
    {
        return $this->sendEmail('Order Shipped', $email, array_merge([
            '{{customer_name}}' => $customerName,
        ], $shippingDetails));
    }

    public function sendOrderDelivered(string $email, string $customerName, string $orderNumber)
    {
        return $this->sendEmail('Order Delivered', $email, [
            '{{customer_name}}' => $customerName,
            '{{order_number}}' => $orderNumber,
        ]);
    }

    public function sendOrderCancelled(string $email, string $customerName, array $cancellationDetails)
    {
        return $this->sendEmail('Order Cancelled', $email, array_merge([
            '{{customer_name}}' => $customerName,
        ], $cancellationDetails));
    }

    public function sendRegistrationVerification(string $email, string $userName, string $verificationLink)
    {
        return $this->sendEmail('New Customer Registration', $email, [
            '{{user_name}}' => $userName,
            '{{user_email}}' => $email,
            '{{verification_link}}' => $verificationLink,
        ]);
    }
}
