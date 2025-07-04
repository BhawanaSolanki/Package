<?php

return [

    // Default payment gateway
    'default' => env('PAYMENT_GATEWAY', 'razorpay'),

    // All supported gateways and their env-based config
    'gateways' => [

        'razorpay' => [
            'key'    => env('RAZORPAY_KEY'),
            'secret' => env('RAZORPAY_SECRET'),
        ],

        'paypal' => [
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'secret'    => env('PAYPAL_SECRET'),
        ],

        'stripe' => [
            'key'    => env('STRIPE_KEY'),
            'secret' => env('STRIPE_SECRET'),
        ],

    ]

];
