<?php

namespace Bhawana\SchoolPay\Gateways;

interface PaymentGatewayInterface
{
    public function initialize(array $config): void;

    public function createPayment(array $data);

    public function verifyPayment(array $data);

    public function getPaymentStatus(string $paymentId);
}
