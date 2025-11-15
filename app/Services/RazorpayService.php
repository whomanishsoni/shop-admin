<?php

namespace App\Services;

use Razorpay\Api\Api;
use App\Models\PaymentGateway;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $gateway = PaymentGateway::where('gateway_key', 'razorpay')->first();

        if ($gateway && $gateway->status) {
            $mode = $gateway->mode;
            $keyId = $gateway->{$mode . '_key_id'};
            $keySecret = $gateway->{$mode . '_key_secret'};

            if ($keyId && $keySecret) {
                $this->api = new Api($keyId, $keySecret);
            }
        }
    }

    public function createOrder(Order $order)
    {
        if (!$this->api) {
            throw new \Exception('Razorpay is not configured');
        }

        $amount = (int)($order->total * 100); // Razorpay expects amount in paisa

        $razorpayOrder = $this->api->order->create([
            'receipt' => $order->order_number,
            'amount' => $amount,
            'currency' => 'INR',
            'payment_capture' => 1, // Auto capture
        ]);

        Log::info('Razorpay order created', [
            'order_id' => $order->id,
            'razorpay_order_id' => $razorpayOrder->id,
            'amount' => $amount
        ]);

        return $razorpayOrder;
    }

    public function verifyPayment($razorpayOrderId, $razorpayPaymentId, $razorpaySignature)
    {
        if (!$this->api) {
            throw new \Exception('Razorpay is not configured');
        }

        try {
            $attributes = [
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId,
                'razorpay_signature' => $razorpaySignature
            ];

            $this->api->utility->verifyPaymentSignature($attributes);

            Log::info('Razorpay payment verified', [
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Razorpay payment verification failed', [
                'error' => $e->getMessage(),
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId
            ]);
            return false;
        }
    }

    public function processPaymentSuccess(Order $order, $razorpayOrderId, $razorpayPaymentId)
    {
        Log::info('Processing payment success start', [
            'order_id' => $order->id,
            'current_payment_status' => $order->payment_status,
            'current_status' => $order->status
        ]);

        // Update order status
        $updated = $order->update([
            'payment_status' => 'paid',
            'payment_method' => 'razorpay',
            'status' => 'confirmed'
        ]);

        Log::info('Order update result', [
            'order_id' => $order->id,
            'updated' => $updated,
            'new_payment_status' => $order->fresh()->payment_status,
            'new_status' => $order->fresh()->status
        ]);

        // Get payment details from Razorpay for storage
        $paymentData = null;
        $paymentMode = null;
        $bankName = null;
        $cardType = null;
        $cardNetwork = null;
        $walletName = null;
        $vpa = null;
        $fee = null;
        $tax = null;
        $acquirerData = null;
        $errorCode = null;
        $errorDescription = null;

        try {
            if ($this->api) {
                $payment = $this->api->payment->fetch($razorpayPaymentId);
                $paymentArray = $payment->toArray();
                $paymentData = json_encode($paymentArray);

                // Extract payment method details
                if (isset($paymentArray['method'])) {
                    $paymentMode = $paymentArray['method']; // card, upi, netbanking, wallet
                }

                // Extract card details
                if ($paymentMode === 'card' && isset($paymentArray['card'])) {
                    $card = $paymentArray['card'];
                    $cardType = isset($card['type']) ? $card['type'] : null; // credit, debit
                    $cardNetwork = isset($card['network']) ? $card['network'] : null; // Visa, Mastercard, etc.
                }

                // Extract bank details
                if (isset($paymentArray['bank'])) {
                    $bankName = $paymentArray['bank'];
                }

                // Extract wallet details
                if ($paymentMode === 'wallet' && isset($paymentArray['wallet'])) {
                    $walletName = $paymentArray['wallet'];
                }

                // Extract VPA for UPI payments
                if ($paymentMode === 'upi' && isset($paymentArray['vpa'])) {
                    $vpa = $paymentArray['vpa'];
                }

                // Extract fee and tax information
                if (isset($paymentArray['fee'])) {
                    $fee = $paymentArray['fee'] / 100; // Convert from paisa to rupees
                }

                if (isset($paymentArray['tax'])) {
                    $tax = $paymentArray['tax'] / 100; // Convert from paisa to rupees
                }

                // Extract acquirer data
                if (isset($paymentArray['acquirer_data'])) {
                    $acquirerData = json_encode($paymentArray['acquirer_data']);
                }

                // Extract error information
                if (isset($paymentArray['error_code'])) {
                    $errorCode = $paymentArray['error_code'];
                }

                if (isset($paymentArray['error_description'])) {
                    $errorDescription = $paymentArray['error_description'];
                }
            }
        } catch (\Exception $e) {
            Log::warning('Could not fetch payment details from Razorpay', [
                'payment_id' => $razorpayPaymentId,
                'error' => $e->getMessage()
            ]);
        }

        // Create transaction record
        $transaction = Transaction::create([
            'order_id' => $order->id,
            'transaction_id' => $razorpayPaymentId,
            'gateway_order_id' => $razorpayOrderId,
            'amount' => $order->total,
            'currency' => 'INR',
            'payment_method' => 'razorpay',
            'payment_mode' => $paymentMode,
            'bank_name' => $bankName,
            'card_type' => $cardType,
            'card_network' => $cardNetwork,
            'wallet_name' => $walletName,
            'vpa' => $vpa,
            'fee' => $fee,
            'tax' => $tax,
            'acquirer_data' => $acquirerData,
            'error_code' => $errorCode,
            'error_description' => $errorDescription,
            'gateway_response' => $paymentData,
            'status' => 'paid',
            'payment_date' => now()
        ]);
        Log::info('Transaction created', [
            'transaction_id' => $transaction->id,
            'order_id' => $order->id,
            'razorpay_payment_id' => $razorpayPaymentId
        ]);

        Log::info('Order payment completed', [
            'order_id' => $order->id,
            'razorpay_payment_id' => $razorpayPaymentId
        ]);
    }

    public function getKeyId()
    {
        $gateway = PaymentGateway::where('gateway_key', 'razorpay')->first();

        if ($gateway && $gateway->status) {
            $mode = $gateway->mode;
            return $gateway->{$mode . '_key_id'};
        }

        return null;
    }
}
