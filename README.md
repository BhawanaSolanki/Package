# SchoolPay - Laravel Payment Integration Package

SchoolPay is a Laravel package to manage school fee payments using multiple payment gateways like Razorpay, Stripe, and PayPal (mock).

## ✨ Features

- Razorpay integration
- Stripe integration
- Dummy PayPal support
- Extensible gateway interface
- Simple API routes for create, verify, and get status
- Configurable via `config/payment.php`

## 🚀 Installation (Local Dev)

```bash
# Inside your Laravel root composer.json
"repositories": [
  {
    "type": "path",
    "url": "packages/bhawana/schoolpay"
  }
],
"require": {
  "bhawana/schoolpay": "dev-main"
}
