# When Do Users Get Access to Training Courses?

## 🎯 Simple Answer

**Users get access to training courses when:**
- ✅ **Enrollment Status = `paid`**
- ✅ Payment has been completed successfully
- ✅ `enrolled_at` timestamp is set

## 📊 The Flow

### Step 1: User Enrolls
- User clicks "Enroll" on a training
- **Enrollment** created with status: `pending`
- ❌ **NO ACCESS YET** - User cannot access the course

### Step 2: Payment Initiated
- Payment gateway (Stripe/Razorpay) is called
- **Payment** created with status: `pending`
- ❌ **NO ACCESS YET** - Payment not completed

### Step 3: Payment Succeeds
- User completes payment
- **Payment** status → `succeeded` ✅
- **Enrollment** status → `paid` ✅
- `enrolled_at` timestamp is set ✅
- ✅ **ACCESS GRANTED** - User can now access the course!

## 🔑 Key Points

### Enrollment Status = Access Control
- **`paid`** = ✅ User HAS access
- **`pending`** = ❌ User does NOT have access (waiting for payment)
- **`failed`** = ❌ User does NOT have access (payment failed)
- **`cancelled`** = ❌ User does NOT have access (enrollment cancelled)

### Payment Status = Financial Record
- **`succeeded`** = Money received ✅
- **`pending`** = Payment in progress ⏳
- **`failed`** = Payment failed ❌
- **`refunded`** = Money returned 💰

## 🔄 The Relationship

```
Payment Status: succeeded
        ↓
Enrollment Status: paid
        ↓
User Gets Access ✅
```

**Important:** 
- Payment status does NOT directly control access
- Enrollment status controls access
- Payment status affects enrollment status automatically

## 💡 Why Two Separate Statuses?

### Payment Status
- Tracks the **financial transaction**
- Used for accounting and refunds
- Shows if money was received

### Enrollment Status
- Tracks the **user's access**
- Controls course access
- Shows if user can attend training

## 🛠️ For Admins

### To Grant Access:
1. Check if payment succeeded
2. If payment succeeded → Enrollment should be `paid`
3. If enrollment is `paid` → User has access ✅

### To Revoke Access:
1. Change enrollment status to `cancelled` or `failed`
2. User loses access immediately ❌
3. Process refund if needed (separate action)

## 📝 Example Scenarios

### Scenario 1: Normal Flow
1. User enrolls → Enrollment: `pending`
2. User pays → Payment: `succeeded`, Enrollment: `paid`
3. ✅ User gets access

### Scenario 2: Payment Pending
1. User enrolls → Enrollment: `pending`
2. Payment initiated → Payment: `pending`, Enrollment: `pending`
3. ❌ User does NOT have access (waiting for payment)

### Scenario 3: Payment Failed
1. User enrolls → Enrollment: `pending`
2. Payment fails → Payment: `failed`, Enrollment: `failed`
3. ❌ User does NOT have access

### Scenario 4: Admin Manual Update
1. Admin changes enrollment to `paid` → Enrollment: `paid`
2. Payment status syncs to `succeeded`
3. ✅ User gets access (even if payment wasn't verified)

## 🎓 Summary

**Access = Enrollment Status = `paid`**

- Payment is the **financial record**
- Enrollment is the **access record**
- When payment succeeds → enrollment becomes paid → user gets access


