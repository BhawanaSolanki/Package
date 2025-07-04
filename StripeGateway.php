<?php

namespace Bhawana\SchoolPay\Gateways;

use Bhawana\SchoolPay\Gateways\PaymentGatewayInterface;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;

class StripeGateway implements PaymentGatewayInterface
{
    protected $secret;

    public function initialize(array $config): void
    {
        $this->secret = $config['secret'];
        Stripe::setApiKey($this->secret);
    }

    public function createPayment(array $data)
    {
        try {
            $intent = PaymentIntent::create([
                'amount' => $data['amount'] * 100, // amount in paisa/cents
                'currency' => $data['currency'] ?? 'usd',
                'description' => $data['description'] ?? 'School Fee Payment',
                'metadata' => [
                    'receipt' => $data['receipt'] ?? 'receipt_' . uniqid(),
                ],
            ]);

            return [
                'id' => $intent->id,
                'client_secret' => $intent->client_secret,
                'status' => $intent->status,
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function verifyPayment(array $data)
    {
        try {
            $intent = PaymentIntent::retrieve($data['payment_id']);
            return $intent->status === 'succeeded';
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getPaymentStatus(string $paymentId)
    {
        try {
            $intent = PaymentIntent::retrieve($paymentId);
            return $intent->status;
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
