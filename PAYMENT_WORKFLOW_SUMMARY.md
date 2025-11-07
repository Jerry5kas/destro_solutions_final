# Payment & Transaction Management - Quick Reference

## 🔄 Payment Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    USER ENROLLMENT FLOW                         │
└─────────────────────────────────────────────────────────────────┘

1. USER BROWSES TRAININGS
   └─> /training or /trainings
       └─> Views available courses

2. USER SELECTS TRAINING
   └─> /trainings/{slug}
       └─> Views details, price, duration
       └─> Selects payment gateway (Stripe/Razorpay)
       └─> Accepts terms & conditions
       └─> Clicks "Enroll & Continue to Payment"

3. SYSTEM CREATES ENROLLMENT
   └─> EnrollmentController@store
       ├─> Validates user (must be logged in, non-admin)
       ├─> Validates training availability
       ├─> Creates Enrollment record (status: pending)
       └─> Records terms acceptance

4. PAYMENT INITIALIZATION
   └─> PaymentServiceManager::gateway()
       ├─> Gets StripeService or RazorpayService
       └─> Calls createPayment()
           ├─> Stripe: Creates PaymentIntent
           └─> Razorpay: Creates Order
       └─> Creates Payment record (status: pending)

5. REDIRECT TO CHECKOUT
   └─> /payment/checkout
       ├─> Shows order summary
       └─> Displays payment form
           ├─> Stripe: Card input (Stripe Elements)
           └─> Razorpay: Payment button (Checkout.js)

6. USER COMPLETES PAYMENT
   ├─> Stripe: Card payment via Stripe Elements
   └─> Razorpay: UPI/Card/Netbanking via Razorpay modal

7. PAYMENT RESULT
   ├─> SUCCESS → /checkout/success?gateway=...&payment_id=...
   └─> FAILURE → /checkout/failed?gateway=...&reason=...

8. PAYMENT VERIFICATION
   └─> CheckoutController@success
       ├─> Retrieves Payment record
       ├─> Verifies payment with gateway
       ├─> Updates Payment status → succeeded
       ├─> Updates Enrollment status → paid
       └─> Redirects to user dashboard

9. WEBHOOK PROCESSING (Async Backup)
   └─> WebhookController
       ├─> Receives webhook from gateway
       ├─> Verifies signature
       ├─> Updates Payment & Enrollment status
       └─> Ensures data consistency
```

---

## 📊 Transaction States

### Enrollment Status Flow
```
pending → paid → (active enrollment)
   ↓
failed
```

### Payment Status Flow
```
pending → succeeded
   ↓
failed
```

---

## 🗄️ Database Structure

### Key Tables

**enrollments**
- Links user to training
- Tracks enrollment status
- Stores payment method and amount

**payments**
- Stores transaction details
- Links to enrollment
- Tracks gateway payment IDs
- Stores payment status and metadata

**payment_settings**
- Gateway configuration
- Encrypted API keys
- Enable/disable gateways
- Default currency

---

## 🔐 Security Layers

1. **Encrypted Storage**
   - API keys stored encrypted in database
   - Never exposed in frontend

2. **Webhook Verification**
   - Signature verification for all webhooks
   - Prevents unauthorized access

3. **Payment Verification**
   - Server-side verification before status update
   - Gateway payment IDs for audit trail

4. **User Authentication**
   - Enrollment requires login
   - Admin users cannot enroll

---

## 🛠️ Management Interfaces

### Admin Panel
- **Payment Settings** (`/admin/payment-settings`)
  - Enable/disable gateways
  - Configure API keys
  - Set default gateway
  - Set currency

### User Dashboard
- **Dashboard** (`/user/dashboard`)
  - View recent enrollments
  - See enrollment statistics
- **Enrollments** (`/user/enrollments`)
  - View all enrollments
  - See enrollment status
- **Payments** (`/user/payments`)
  - View payment history
  - See payment details

---

## 🔄 Payment Gateway Comparison

| Feature | Stripe | Razorpay |
|---------|--------|----------|
| **Region** | Global | India-focused |
| **Payment Methods** | Cards, Wallets | UPI, Cards, Netbanking |
| **Currency** | Multi-currency | INR primary |
| **Integration** | Stripe Elements | Checkout.js |
| **Webhook** | payment_intent.succeeded | payment.captured |

---

## 📋 Key Service Classes

### PaymentServiceManager
- Factory for gateway instances
- Checks gateway availability
- Returns enabled gateways

### PaymentHelper
- Creates payment records
- Updates payment status
- Processes success/failure
- Formats amounts

### StripeService / RazorpayService
- Gateway-specific implementations
- Payment creation
- Payment verification
- Refund processing
- Webhook verification

---

## 🚨 Common Issues & Solutions

### Payment Not Updating
- **Check**: Webhook configuration
- **Verify**: Webhook signatures
- **Review**: Payment gateway logs
- **Check**: `payments` table status

### Enrollment Not Activating
- **Verify**: Payment status is `succeeded`
- **Check**: `enrollments` table
- **Review**: `PaymentHelper::processSuccessfulPayment()`

### Gateway Not Working
- **Verify**: API keys in admin panel
- **Check**: Gateway enabled status
- **Review**: Service logs
- **Test**: API keys with gateway

---

## 📈 Future Enhancements

### Recommended Features
1. **Admin Payment Management**
   - View all payments
   - Filter and search
   - Manual verification
   - Refund processing

2. **Admin Enrollment Management**
   - View all enrollments
   - Status updates
   - Cancel enrollments

3. **Reporting & Analytics**
   - Revenue reports
   - Payment analytics
   - Export functionality

4. **User Features**
   - Payment receipts
   - Enrollment certificates
   - Cancel enrollments

---

## 🔗 Important Routes

### Public Routes
- `/training` - Browse trainings
- `/trainings` - List enrollable trainings
- `/trainings/{slug}` - Training details

### User Routes (Auth Required)
- `/user/dashboard` - User dashboard
- `/user/enrollments` - All enrollments
- `/user/payments` - Payment history
- `/trainings/{slug}/enroll` - Enroll in training

### Payment Routes
- `/payment/checkout` - Checkout page
- `/checkout/success` - Payment success
- `/checkout/failed` - Payment failure
- `/webhooks/stripe` - Stripe webhook
- `/webhooks/razorpay` - Razorpay webhook

### Admin Routes
- `/admin/payment-settings` - Payment configuration
- `/admin/dashboard` - Admin dashboard

---

## 📝 Quick Setup Checklist

- [ ] Configure payment gateways in admin panel
- [ ] Set up webhook URLs in gateway dashboards
- [ ] Test payment flow with test cards/accounts
- [ ] Verify webhook processing
- [ ] Check payment status updates
- [ ] Verify enrollment activation
- [ ] Test user dashboard views

---

For detailed information, see `PAYMENT_WORKFLOW.md`

