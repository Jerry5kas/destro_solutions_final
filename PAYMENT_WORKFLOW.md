# Payment & Transaction Management Workflow

## Overview
This document outlines the complete payment and transaction management workflow for the Destrosolutions training enrollment system. The system supports multiple payment gateways (Stripe and Razorpay) and provides comprehensive transaction tracking.

---

## 🏗️ System Architecture

### Database Tables

1. **`enrollments`** - Stores training enrollment records
   - `user_id`, `training_id`, `payment_method`, `payment_id`
   - `amount`, `currency`, `status` (pending/paid/failed)
   - `enrolled_at`, `terms_accepted`, `terms_accepted_at`
   - `subscription_id`, `subscription_status`, `notes`

2. **`payments`** - Stores payment transaction records
   - `user_id`, `enrollment_id`, `gateway` (stripe/razorpay)
   - `gateway_payment_id`, `amount`, `currency`
   - `status` (pending/succeeded/failed)
   - `payment_method`, `metadata`, `failure_reason`, `paid_at`

3. **`payment_settings`** - Stores payment gateway configuration
   - `stripe_enabled`, `razorpay_enabled`, `default_gateway`
   - `stripe_key`, `stripe_secret`, `stripe_webhook_secret` (encrypted)
   - `razorpay_key`, `razorpay_secret`, `razorpay_webhook_secret` (encrypted)
   - `currency`

4. **`user_profiles`** - Extended user information
   - `user_id`, `phone`, `address`, `city`, `state`, `country`
   - `company`, `designation`, `date_of_birth`, `profile_image`, `bio`

---

## 🔄 Complete Payment Workflow

### Phase 1: User Enrollment Initiation

1. **User browses training** (`/training` or `/trainings`)
   - Views available training courses
   - Clicks on a training card to see details

2. **User views training details** (`/trainings/{slug}`)
   - Sees training information, price, duration
   - Selects payment gateway (Stripe or Razorpay - if both enabled)
   - Accepts terms and conditions
   - Clicks "Enroll & Continue to Payment"

3. **System creates enrollment** (`EnrollmentController@store`)
   - Validates user authentication (must be logged in, non-admin)
   - Validates training availability (`isEnrollable()`, `hasAvailableSpots()`)
   - Creates `Enrollment` record with status `pending`
   - Records terms acceptance

### Phase 2: Payment Initialization

4. **Payment gateway initialization**
   - System calls `PaymentServiceManager::gateway($gateway)`
   - Gets `StripeService` or `RazorpayService` instance
   - Calls `createPayment()` method:
     - **Stripe**: Creates `PaymentIntent`, returns `client_secret` and `payment_id`
     - **Razorpay**: Creates `Order`, returns `order_id` and `key_id`

5. **Payment record creation**
   - Creates `Payment` record with:
     - `gateway_payment_id` (PaymentIntent ID or Order ID)
     - `status`: `pending`
     - Links to `enrollment_id` and `user_id`
     - Stores gateway metadata

6. **Redirect to checkout page** (`/payment/checkout`)
   - Displays order summary
   - Shows payment form based on selected gateway:
     - **Stripe**: Stripe Elements (card input)
     - **Razorpay**: Razorpay Checkout.js button

### Phase 3: Payment Processing

7. **User completes payment**
   - **Stripe Flow**:
     - User enters card details
     - Stripe Elements validates card
     - On submit, `stripe.confirmCardPayment()` is called
     - Payment is processed by Stripe
   
   - **Razorpay Flow**:
     - User clicks "Pay" button
     - Razorpay modal opens
     - User selects payment method (UPI/Card/Netbanking)
     - Payment is processed by Razorpay

8. **Payment success/failure handling**
   - **Success**: Redirects to `/checkout/success?gateway=stripe&payment_id=...`
   - **Failure**: Redirects to `/checkout/failed?gateway=stripe&reason=...`

### Phase 4: Payment Verification

9. **Payment verification** (`CheckoutController@success`)
   - Retrieves `Payment` record by `gateway_payment_id`
   - Calls gateway's `verifyPayment()` method:
     - **Stripe**: Retrieves `PaymentIntent`, checks status
     - **Razorpay**: Verifies signature, retrieves payment details
   - If verification succeeds:
     - Calls `PaymentHelper::processSuccessfulPayment($payment)`
     - Updates `Payment` status to `succeeded`
     - Updates `Enrollment` status to `paid`
     - Sets `enrolled_at` timestamp
   - Redirects to user dashboard with success message

10. **Payment failure handling** (`CheckoutController@failed`)
    - Retrieves `Payment` record
    - Calls `PaymentHelper::processFailedPayment($payment, $reason)`
    - Updates `Payment` status to `failed`
    - Updates `Enrollment` status to `failed`
    - Records `failure_reason`
    - Redirects to user dashboard with error message

### Phase 5: Webhook Processing (Asynchronous)

11. **Webhook reception** (`WebhookController`)
    - **Stripe Webhook** (`/webhooks/stripe`):
      - Receives `payment_intent.succeeded` event
      - Verifies webhook signature
      - Finds `Payment` by `gateway_payment_id`
      - Calls `PaymentHelper::processSuccessfulPayment()`
    
    - **Razorpay Webhook** (`/webhooks/razorpay`):
      - Receives payment captured event
      - Verifies webhook signature
      - Finds `Payment` by `gateway_payment_id`
      - Calls `PaymentHelper::processSuccessfulPayment()`

12. **Webhook benefits**
    - Handles cases where user closes browser before redirect
    - Ensures payment status is always synchronized
    - Provides backup verification mechanism

---

## 🔐 Security Features

1. **Encrypted API Keys**
   - All gateway secrets stored in `payment_settings` with `encrypted` cast
   - Keys are never exposed in frontend or logs

2. **Webhook Signature Verification**
   - Stripe: Uses `Stripe\Webhook::constructEvent()`
   - Razorpay: Uses HMAC SHA256 signature verification
   - Prevents unauthorized webhook calls

3. **Payment Verification**
   - All payments verified server-side before status update
   - Gateway payment IDs stored for audit trail
   - Metadata stored for debugging and reconciliation

4. **User Authentication**
   - Enrollment requires authenticated user (non-admin)
   - Payment records linked to user accounts
   - Admin users cannot enroll in trainings

---

## 📊 Transaction States

### Enrollment Statuses
- `pending` - Enrollment created, payment not completed
- `paid` - Payment successful, enrollment active
- `failed` - Payment failed or cancelled

### Payment Statuses
- `pending` - Payment initiated, awaiting completion
- `succeeded` - Payment completed successfully
- `failed` - Payment failed or was cancelled

### Payment Gateway Status
- Managed via `PaymentSetting` model
- `stripe_enabled` / `razorpay_enabled` - Enable/disable gateways
- `default_gateway` - Default selection when both enabled

---

## 🛠️ Admin Management

### Payment Settings (`/admin/payment-settings`)
- **Enable/Disable Gateways**: Toggle Stripe and Razorpay
- **Configure API Keys**: Set public keys, secrets, webhook secrets
- **Set Default Gateway**: Choose default when both enabled
- **Set Currency**: Configure default currency

### Current Admin Features
- ✅ Payment gateway configuration
- ✅ Enable/disable gateways
- ✅ Encrypted key storage

### Recommended Admin Features (To Be Implemented)
- ⏳ **Payment Management** (`/admin/payments`)
  - View all payments with filters (status, gateway, date range)
  - View payment details (user, enrollment, gateway data)
  - Manual payment verification
  - Refund processing
  
- ⏳ **Enrollment Management** (`/admin/enrollments`)
  - View all enrollments
  - Filter by status, training, user
  - View enrollment details
  - Manual enrollment status updates
  - Cancel enrollments
  
- ⏳ **Transaction Reports**
  - Revenue reports (daily, weekly, monthly)
  - Payment gateway comparison
  - Failed payment analysis
  - Refund tracking

---

## 👤 User Dashboard Features

### Current User Features
- ✅ View enrolled courses (`/user/dashboard`)
- ✅ View profile (`/user/profile`)
- ✅ View enrollments (`/user/enrollments`) - Route exists
- ✅ View payments (`/user/payments`) - Route exists

### Recommended User Features (To Be Implemented)
- ⏳ View payment history with details
- ⏳ Download payment receipts/invoices
- ⏳ View enrollment certificates
- ⏳ Cancel enrollments (if allowed)

---

## 🔄 Refund Workflow (Future Implementation)

1. **Admin initiates refund** (`/admin/payments/{id}/refund`)
2. **System calls gateway's `refundPayment()` method**
3. **Gateway processes refund**
4. **Webhook confirms refund** (if supported)
5. **System updates records**:
   - `Payment` status updated
   - `Enrollment` status updated (if full refund)
   - Refund record created (new table needed)

---

## 📝 Key Service Classes

### `PaymentServiceManager`
- Factory class for getting gateway instances
- `gateway($name)` - Returns StripeService or RazorpayService
- `isGatewayEnabled($name)` - Checks if gateway is enabled
- `getAvailableGateways()` - Returns enabled gateways

### `PaymentHelper`
- `createPaymentRecord($data)` - Creates payment record
- `updatePaymentStatus($payment, $status)` - Updates payment
- `processSuccessfulPayment($payment)` - Handles success
- `processFailedPayment($payment, $reason)` - Handles failure
- `formatAmount($amount, $currency)` - Formats for display

### `StripeService` / `RazorpayService`
- Implement `PaymentGatewayInterface`
- `createPayment()` - Initialize payment
- `verifyPayment()` - Verify payment status
- `refundPayment()` - Process refunds
- `verifyWebhook()` - Verify webhook signatures

---

## 🚀 Setup Instructions

### 1. Configure Payment Gateways
1. Go to `/admin/payment-settings`
2. Enable desired gateways (Stripe/Razorpay)
3. Enter API keys and webhook secrets
4. Set default gateway and currency
5. Save settings

### 2. Configure Webhooks
- **Stripe**: Set webhook URL to `https://yourdomain.com/webhooks/stripe`
  - Events: `payment_intent.succeeded`, `payment_intent.payment_failed`
- **Razorpay**: Set webhook URL to `https://yourdomain.com/webhooks/razorpay`
  - Events: `payment.captured`, `payment.failed`

### 3. Test Payment Flow
1. Create a test training with price
2. Log in as a regular user (non-admin)
3. Browse to training and enroll
4. Complete test payment
5. Verify enrollment status in dashboard

---

## 📋 Database Relationships

```
User
  ├── hasMany Enrollments
  ├── hasMany Payments
  └── hasOne UserProfile

Enrollment
  ├── belongsTo User
  ├── belongsTo ContentItem (training)
  └── hasOne Payment

Payment
  ├── belongsTo User
  └── belongsTo Enrollment

ContentItem (Training)
  └── hasMany Enrollments
```

---

## 🔍 Troubleshooting

### Payment Not Updating
- Check webhook configuration
- Verify webhook signatures
- Check payment gateway logs
- Review `payments` table for status

### Enrollment Not Activating
- Verify payment status is `succeeded`
- Check `enrollments` table for status
- Review `PaymentHelper::processSuccessfulPayment()` logic

### Gateway Not Working
- Verify API keys in `/admin/payment-settings`
- Check gateway is enabled
- Review gateway service logs
- Test API keys directly with gateway

---

## 📚 Additional Resources

- **Stripe Documentation**: https://stripe.com/docs
- **Razorpay Documentation**: https://razorpay.com/docs
- **Laravel Encryption**: https://laravel.com/docs/encryption

---

## 🎯 Next Steps

1. **Implement Admin Payment Management**
   - Create `Admin/PaymentController`
   - Create `Admin/EnrollmentController`
   - Build admin views for payments and enrollments

2. **Implement Refund System**
   - Add refund functionality to admin panel
   - Create refunds table
   - Implement refund workflow

3. **Add Reporting**
   - Revenue reports
   - Payment analytics
   - Export functionality

4. **Enhance User Dashboard**
   - Payment history
   - Receipt downloads
   - Enrollment certificates

