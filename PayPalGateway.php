<?php

namespace Bhawana\SchoolPay\Gateways;

use Bhawana\SchoolPay\Gateways\PaymentGatewayInterface;

class PayPalGateway implements PaymentGatewayInterface
{
    protected $clientId;
    protected $secret;

    public function initialize(array $config): void
    {
        $this->clientId = $config['client_id'];
        $this->secret = $config['secret'];
        // Yahan future me PayPal SDK init hoga
    }

    public function createPayment(array $data)
    {
        // Dummy return for now
        return [
            'id' => 'PAYPAL_ORDER_'.uniqid(),
            'status' => 'CREATED',
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'USD',
        ];
    }

    public function verifyPayment(array $data)
    {
        // Assume verify is always true for now
        return true;
    }

    public function getPaymentStatus(string $paymentId)
    {
        // Dummy status
        return 'COMPLETED';
    }
}
