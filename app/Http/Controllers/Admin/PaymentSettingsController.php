<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    public function edit()
    {
        $settings = PaymentSetting::current();
        return view('admin.payment-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'stripe_enabled' => ['nullable', 'boolean'],
            'razorpay_enabled' => ['nullable', 'boolean'],
            'default_gateway' => ['required', 'in:stripe,razorpay'],
            'currency' => ['required', 'string', 'max:6'],
            'stripe_key' => ['nullable', 'string'],
            'stripe_secret' => ['nullable', 'string'],
            'stripe_webhook_secret' => ['nullable', 'string'],
            'razorpay_key' => ['nullable', 'string'],
            'razorpay_secret' => ['nullable', 'string'],
            'razorpay_webhook_secret' => ['nullable', 'string'],
        ]);

        $settings = PaymentSetting::current();
        $settings->stripe_enabled = (bool) $request->boolean('stripe_enabled');
        $settings->razorpay_enabled = (bool) $request->boolean('razorpay_enabled');
        $settings->default_gateway = $validated['default_gateway'];
        $settings->currency = $validated['currency'];

        // Only overwrite secrets if provided (so we never echo them back)
        foreach ([
            'stripe_key', 'stripe_secret', 'stripe_webhook_secret',
            'razorpay_key', 'razorpay_secret', 'razorpay_webhook_secret',
        ] as $field) {
            if (!empty($validated[$field])) {
                $settings->$field = $validated[$field];
            }
        }

        $settings->save();

        return back()->with('success', 'Payment settings updated successfully.');
    }
}
