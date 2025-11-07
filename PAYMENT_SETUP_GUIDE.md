# Payment Gateway Setup Guide

## Environment Variables

Add the following to your `.env` file:

### Stripe Configuration
```env
# Stripe Keys (Get from https://dashboard.stripe.com/apikeys)
STRIPE_KEY=pk_test_your_publishable_key_here
STRIPE_SECRET=sk_test_your_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
STRIPE_ENABLED=true
```

### Razorpay Configuration
```env
# Razorpay Keys (Get from https://dashboard.razorpay.com/app/keys)
RAZORPAY_KEY=rzp_test_your_key_id_here
RAZORPAY_SECRET=your_key_secret_here
RAZORPAY_WEBHOOK_SECRET=your_webhook_secret_here
RAZORPAY_ENABLED=true
```

### Payment Settings
```env
# Default Payment Gateway (stripe or razorpay)
PAYMENT_DEFAULT_GATEWAY=stripe

# Default Currency
PAYMENT_CURRENCY=USD

# Payment Limits
PAYMENT_MIN_AMOUNT=1.00
PAYMENT_MAX_AMOUNT=100000.00
PAYMENT_TIMEOUT_MINUTES=30
```

## Getting API Keys

### Stripe
1. Sign up at https://stripe.com
2. Go to Developers → API keys
3. Copy your **Publishable key** (starts with `pk_test_`)
4. Copy your **Secret key** (starts with `sk_test_`)
5. For webhooks, go to Developers → Webhooks and create an endpoint

### Razorpay
1. Sign up at https://razorpay.com
2. Go to Settings → API Keys
3. Generate test keys
4. Copy your **Key ID** (starts with `rzp_test_`)
5. Copy your **Key Secret**
6. For webhooks, go to Settings → Webhooks and configure

## Testing

### Test Cards (Stripe)
- Success: `4242 4242 4242 4242`
- Decline: `4000 0000 0000 0002`
- 3D Secure: `4000 0025 0000 3155`

### Test Cards (Razorpay)
- Success: `4111 1111 1111 1111`
- Decline: `4000 0000 0000 0002`

## Usage Example

```php
use App\Services\Payment\PaymentServiceManager;

// Get Stripe service
$stripe = PaymentServiceManager::gateway('stripe');

// Create payment
$result = $stripe->createPayment(100.00, 'USD', [
    'enrollment_id' => 1,
    'user_id' => 1,
]);

// Verify payment
$verification = $stripe->verifyPayment($paymentId);
```

## Webhook Setup

### Stripe Webhook URL
```
https://yourdomain.com/webhooks/stripe
```

### Razorpay Webhook URL
```
https://yourdomain.com/webhooks/razorpay
```

## Security Notes

1. **Never commit** `.env` file to version control
2. Use **test keys** during development
3. Switch to **live keys** only in production
4. Always verify webhook signatures
5. Use HTTPS for all payment pages

