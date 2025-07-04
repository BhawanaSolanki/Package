<?php

namespace Bhawana\SchoolPay\Gateways;

use Razorpay\Api\Api;
use Bhawana\SchoolPay\Gateways\PaymentGatewayInterface;

class RazorpayGateway implements PaymentGatewayInterface
{
    protected $api;
    protected $key;
    protected $secret;

    public function initialize(array $config): void
    {
        $this->key = $config['key'];
        $this->secret = $config['secret'];
        $this->api = new Api($this->key, $this->secret);
    }

    public function createPayment(array $data)
    {
        try {
            return $this->api->order->create([
                'receipt'         => $data['receipt'] ?? 'receipt_'.uniqid(),
                'amount'          => $data['amount'] * 100,
                'currency'        => $data['currency'] ?? 'INR',
                'payment_capture' => 1
            ]);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function verifyPayment(array $data)
    {
        $generatedSignature = hash_hmac(
            'sha256',
            $data['razorpay_order_id'].'|'.$data['razorpay_payment_id'],
            $this->secret
        );

        return $generatedSignature === $data['razorpay_signature'];
    }

    public function getPaymentStatus(string $paymentId)
    {
        try {
            $payment = $this->api->payment->fetch($paymentId);
            return $payment->status;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
