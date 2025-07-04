<?php

namespace bhawana\schoolpay;

use Illuminate\Support\ServiceProvider;
use bhawana\schoolpay\Gateways\PaymentGatewayInterface;
use bhawana\schoolpay\Gateways\RazorpayGateway;
use bhawana\schoolpay\Gateways\PayPalGateway;
use bhawana\schoolpay\Gateways\StripeGateway;

class SchoolPayServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge default config
        $this->mergeConfigFrom(__DIR__ . '/../config/payment.php', 'payment');

        // Bind interface to appropriate gateway
        $this->app->bind(PaymentGatewayInterface::class, function ($app) {
            $gateway = config('payment.default'); // razorpay / paypal / stripe
            $config = config('payment.gateways.' . $gateway);

            switch ($gateway) {
                case 'paypal':
                    $paypal = new PayPalGateway();
                    $paypal->initialize($config);
                    return $paypal;

                case 'stripe':
                    $stripe = new StripeGateway();
                    $stripe->initialize($config);
                    return $stripe;

                case 'razorpay':
                default:
                    $razorpay = new RazorpayGateway();
                    $razorpay->initialize($config);
                    return $razorpay;
            }
        });
    }

   
public function boot()
{
    // Load routes from the package
    $this->loadRoutesFrom(__DIR__ . '/routes/api.php');

    // Publish config (already handled)
    $this->publishes([
        __DIR__ . '/../config/payment.php' => config_path('payment.php'),
    ], 'config');
}
}
