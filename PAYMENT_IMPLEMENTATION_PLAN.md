# Payment & Training Enrollment System - Implementation Plan

## Overview
Implement a complete payment gateway integration (Stripe & Razorpay) for training course enrollment with user dashboard, subscription management, and course tracking.

---

## Phase 1: Database Structure & Models

### 1.1 Create Database Tables

#### `trainings` table (if not exists as content_items)
- Already exists as `content_items` with type='training'
- Need to add: `price`, `currency`, `duration`, `max_students`, `start_date`, `end_date`

#### `enrollments` table (NEW)
- `id`
- `user_id` (foreign key)
- `training_id` (foreign key to content_items)
- `payment_method` (stripe/razorpay)
- `payment_id` (transaction ID from gateway)
- `amount`
- `currency`
- `status` (pending/paid/failed/refunded)
- `enrolled_at`
- `terms_accepted` (boolean)
- `terms_accepted_at`
- `subscription_id` (if recurring)
- `subscription_status` (active/cancelled/expired)
- `timestamps`

#### `payments` table (NEW)
- `id`
- `user_id`
- `enrollment_id`
- `gateway` (stripe/razorpay)
- `gateway_payment_id`
- `amount`
- `currency`
- `status` (pending/succeeded/failed/refunded)
- `payment_method` (card/upi/netbanking/etc)
- `metadata` (JSON for additional data)
- `timestamps`

#### `user_profiles` table (NEW - Optional, extend users table)
- `id`
- `user_id`
- `phone`
- `address`
- `city`
- `state`
- `country`
- `postal_code`
- `company`
- `designation`
- `timestamps`

---

## Phase 2: Payment Gateway Setup

### 2.1 Install Packages
```bash
composer require stripe/stripe-php
composer require razorpay/razorpay
```

### 2.2 Environment Configuration
Add to `.env`:
```
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...

RAZORPAY_KEY=rzp_test_...
RAZORPAY_SECRET=...
RAZORPAY_WEBHOOK_SECRET=...
```

### 2.3 Create Payment Service Classes
- `app/Services/Payment/StripeService.php`
- `app/Services/Payment/RazorpayService.php`
- `app/Services/Payment/PaymentGatewayInterface.php`

---

## Phase 3: User Authentication & Registration

### 3.1 User Registration/Login
- Create `AuthController` for user registration/login
- Create views: `register.blade.php`, `login.blade.php`
- Add routes for authentication
- Email verification (optional)

### 3.2 User Profile Management
- Create `UserProfileController`
- Create profile views
- Add profile update functionality

---

## Phase 4: Training Enrollment Flow

### 4.1 Training Listing Page
- Display available trainings from `content_items` where type='training'
- Show price, duration, dates
- "Enroll Now" button

### 4.2 Enrollment Form
- User information form
- Terms & Conditions checkbox
- Privacy Policy checkbox
- Payment method selection (Stripe/Razorpay)
- Price display

### 4.3 Payment Processing
- Create `EnrollmentController`
- Handle payment initiation
- Process payment via selected gateway
- Handle payment success/failure callbacks
- Webhook handlers for payment status updates

---

## Phase 5: User Dashboard

### 5.1 Dashboard Structure
- Dashboard home (overview)
- My Profile
- My Enrollments
- Payment History
- Settings

### 5.2 Enrolled Courses View
- List of enrolled trainings
- Course progress (if applicable)
- Access course materials
- Download certificates (if applicable)

---

## Phase 6: Admin Features

### 6.1 Enrollment Management
- View all enrollments
- Filter by status, training, date
- Manual enrollment (if needed)
- Refund management

### 6.2 Payment Management
- View all payments
- Payment reports
- Refund processing

---

## Phase 7: Additional Features

### 7.1 Email Notifications
- Enrollment confirmation
- Payment receipt
- Course reminders
- Certificate generation

### 7.2 Subscription Management (if recurring)
- Subscription creation
- Subscription cancellation
- Renewal handling

---

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── RegisterController.php
│   │   │   ├── LoginController.php
│   │   │   └── LogoutController.php
│   │   ├── User/
│   │   │   ├── DashboardController.php
│   │   │   ├── ProfileController.php
│   │   │   └── EnrollmentController.php
│   │   ├── Payment/
│   │   │   ├── PaymentController.php
│   │   │   ├── StripeController.php
│   │   │   └── RazorpayController.php
│   │   └── Training/
│   │       └── TrainingController.php
│   └── Middleware/
│       └── EnsureUserIsAuthenticated.php (Laravel default)
├── Models/
│   ├── Enrollment.php
│   ├── Payment.php
│   └── UserProfile.php
├── Services/
│   └── Payment/
│       ├── PaymentGatewayInterface.php
│       ├── StripeService.php
│       └── RazorpayService.php
└── Mail/
    ├── EnrollmentConfirmation.php
    └── PaymentReceipt.php

database/
└── migrations/
    ├── 2025_XX_XX_create_enrollments_table.php
    ├── 2025_XX_XX_create_payments_table.php
    ├── 2025_XX_XX_create_user_profiles_table.php
    └── 2025_XX_XX_add_pricing_to_content_items.php

resources/
└── views/
    ├── auth/
    │   ├── register.blade.php
    │   └── login.blade.php
    ├── user/
    │   ├── dashboard/
    │   │   └── index.blade.php
    │   ├── profile/
    │   │   └── edit.blade.php
    │   └── enrollments/
    │       └── index.blade.php
    ├── training/
    │   ├── index.blade.php
    │   ├── show.blade.php
    │   └── enroll.blade.php
    └── payment/
        ├── checkout.blade.php
        └── success.blade.php
```

---

## Implementation Order

1. **Step 1**: Database migrations & models
2. **Step 2**: User authentication (register/login)
3. **Step 3**: User dashboard structure
4. **Step 4**: Training listing & detail pages
5. **Step 5**: Payment gateway integration (Stripe first, then Razorpay)
6. **Step 6**: Enrollment flow
7. **Step 7**: User dashboard - enrolled courses
8. **Step 8**: Admin enrollment management
9. **Step 9**: Email notifications
10. **Step 10**: Testing & refinement

---

## Key Features to Implement

### User Side:
- ✅ User registration & login
- ✅ Training browsing
- ✅ Enrollment with payment
- ✅ Terms & conditions acceptance
- ✅ Payment via Stripe/Razorpay
- ✅ Dashboard with enrolled courses
- ✅ Profile management
- ✅ Payment history

### Admin Side:
- ✅ View all enrollments
- ✅ Payment management
- ✅ Refund processing
- ✅ Enrollment reports

---

## Security Considerations

1. **Payment Security**:
   - Never store credit card details
   - Use HTTPS for all payment pages
   - Validate webhook signatures
   - Implement CSRF protection

2. **Data Protection**:
   - Encrypt sensitive user data
   - GDPR compliance (terms acceptance)
   - Secure session management

3. **Access Control**:
   - Middleware for authenticated users
   - Role-based access (admin vs user)
   - Enrollment ownership verification

---

## Testing Checklist

- [ ] User registration
- [ ] User login/logout
- [ ] Training listing
- [ ] Enrollment form
- [ ] Stripe payment flow
- [ ] Razorpay payment flow
- [ ] Payment webhooks
- [ ] Enrollment confirmation
- [ ] User dashboard
- [ ] Course access
- [ ] Admin enrollment management
- [ ] Email notifications

---

## Next Steps

Ready to start implementation? We'll begin with:
1. Database migrations
2. Models creation
3. Basic user authentication
4. Training listing page

Let me know when you're ready to proceed! 🚀

