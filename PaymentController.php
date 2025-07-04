<?php

namespace Bhawana\SchoolPay\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Bhawana\SchoolPay\Gateways\PaymentGatewayInterface;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $gateway = app(PaymentGatewayInterface::class);

        $order = $gateway->createPayment([
            'amount' => $request->input('amount'),
            'currency' => $request->input('currency', 'INR'),
            'receipt' => 'receipt_' . uniqid(),
        ]);

        return response()->json($order);
    }

    public function verifyPayment(Request $request)
    {
        $gateway = app(PaymentGatewayInterface::class);

        $verified = $gateway->verifyPayment($request->all());

        return response()->json([
            'verified' => $verified
        ]);
    }

    public function getStatus($paymentId)
    {
        $gateway = app(PaymentGatewayInterface::class);

        $status = $gateway->getPaymentStatus($paymentId);

        return response()->json([
            'status' => $status
        ]);
    }
}

