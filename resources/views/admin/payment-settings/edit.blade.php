<x-admin-layout title="Payment Settings - Destrosolutions">
    <div style="display:flex; align-items:center; justify-content: space-between; margin-bottom: 1.25rem;">
        <h1 class="page-title">Payment Settings</h1>
    </div>

    @if(session('success'))
        <div style="padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.payment-settings.update') }}" class="dashboard-card" style="padding: 1.25rem;">
        @csrf
        @method('PUT')

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div style="border:1px solid #eef2ff; border-radius:12px; padding: 1rem;">
                <div style="display:flex; align-items:center; justify-content: space-between;">
                    <div>
                        <div style="font-weight:600; color:#111827;">Stripe</div>
                        <div style="color:#6b7280; font-size:.9rem;">Enable card/wallet payments</div>
                    </div>
                    <label style="display:flex; align-items:center; gap:.5rem;">
                        <input type="checkbox" name="stripe_enabled" value="1" {{ $settings->stripe_enabled ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#0D0DE0;">
                        <span style="color:#374151;">Enabled</span>
                    </label>
                </div>
                <div style="margin-top: .75rem; display:grid; gap:.5rem;">
                    <div style="display:flex; align-items:center; justify-content: space-between; gap:.5rem;">
                        <label style="font-weight:600; color:#374151;">Publishable Key</label>
                        @if(!empty($settings->stripe_key))
                            <span style="font-size:.8rem; color:#10b981; background:#d1fae5; border:1px solid #a7f3d0; padding:.1rem .5rem; border-radius:9999px;">Configured</span>
                        @else
                            <span style="font-size:.8rem; color:#92400e; background:#fef3c7; border:1px solid #fde68a; padding:.1rem .5rem; border-radius:9999px;">Not set</span>
                        @endif
                    </div>
                    <input name="stripe_key" type="text" placeholder="pk_test_... (leave blank to keep)" style="width:100%; padding:.75rem 1rem; border:1px solid #e5e7eb; border-radius:10px;">
                    <div style="display:flex; align-items:center; justify-content: space-between; gap:.5rem;">
                        <label style="font-weight:600; color:#374151;">Secret Key</label>
                        @if(!empty($settings->stripe_secret))
                            <span style="font-size:.8rem; color:#10b981; background:#d1fae5; border:1px solid #a7f3d0; padding:.1rem .5rem; border-radius:9999px;">Configured</span>
                        @else
                            <span style="font-size:.8rem; color:#92400e; background:#fef3c7; border:1px solid #fde68a; padding:.1rem .5rem; border-radius:9999px;">Not set</span>
                        @endif
                    </div>
                    <input name="stripe_secret" type="password" placeholder="sk_test_... (leave blank to keep)" style="width:100%; padding:.75rem 1rem; border:1px solid #e5e7eb; border-radius:10px;">
                    <div style="display:flex; align-items:center; justify-content: space-between; gap:.5rem;">
                        <label style="font-weight:600; color:#374151;">Webhook Secret</label>
                        @if(!empty($settings->stripe_webhook_secret))
                            <span style="font-size:.8rem; color:#10b981; background:#d1fae5; border:1px solid #a7f3d0; padding:.1rem .5rem; border-radius:9999px;">Configured</span>
                        @else
                            <span style="font-size:.8rem; color:#92400e; background:#fef3c7; border:1px solid #fde68a; padding:.1rem .5rem; border-radius:9999px;">Not set</span>
                        @endif
                    </div>
                    <input name="stripe_webhook_secret" type="password" placeholder="whsec_... (leave blank to keep)" style="width:100%; padding:.75rem 1rem; border:1px solid #e5e7eb; border-radius:10px;">
                </div>
            </div>

            <div style="border:1px solid #eef2ff; border-radius:12px; padding: 1rem;">
                <div style="display:flex; align-items:center; justify-content: space-between;">
                    <div>
                        <div style="font-weight:600; color:#111827;">Razorpay</div>
                        <div style="color:#6b7280; font-size:.9rem;">Enable UPI/NetBanking (India)</div>
                    </div>
                    <label style="display:flex; align-items:center; gap:.5rem;">
                        <input type="checkbox" name="razorpay_enabled" value="1" {{ $settings->razorpay_enabled ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#0D0DE0;">
                        <span style="color:#374151;">Enabled</span>
                    </label>
                </div>
                <div style="margin-top: .75rem; display:grid; gap:.5rem;">
                    <div style="display:flex; align-items:center; justify-content: space-between; gap:.5rem;">
                        <label style="font-weight:600; color:#374151;">Key ID</label>
                        @if(!empty($settings->razorpay_key))
                            <span style="font-size:.8rem; color:#10b981; background:#d1fae5; border:1px solid #a7f3d0; padding:.1rem .5rem; border-radius:9999px;">Configured</span>
                        @else
                            <span style="font-size:.8rem; color:#92400e; background:#fef3c7; border:1px solid #fde68a; padding:.1rem .5rem; border-radius:9999px;">Not set</span>
                        @endif
                    </div>
                    <input name="razorpay_key" type="text" placeholder="rzp_test_... (leave blank to keep)" style="width:100%; padding:.75rem 1rem; border:1px solid #e5e7eb; border-radius:10px;">
                    <div style="display:flex; align-items:center; justify-content: space-between; gap:.5rem;">
                        <label style="font-weight:600; color:#374151;">Key Secret</label>
                        @if(!empty($settings->razorpay_secret))
                            <span style="font-size:.8rem; color:#10b981; background:#d1fae5; border:1px solid #a7f3d0; padding:.1rem .5rem; border-radius:9999px;">Configured</span>
                        @else
                            <span style="font-size:.8rem; color:#92400e; background:#fef3c7; border:1px solid #fde68a; padding:.1rem .5rem; border-radius:9999px;">Not set</span>
                        @endif
                    </div>
                    <input name="razorpay_secret" type="password" placeholder="•••••• (leave blank to keep)" style="width:100%; padding:.75rem 1rem; border:1px solid #e5e7eb; border-radius:10px;">
                    <div style="display:flex; align-items:center; justify-content: space-between; gap:.5rem;">
                        <label style="font-weight:600; color:#374151;">Webhook Secret</label>
                        @if(!empty($settings->razorpay_webhook_secret))
                            <span style="font-size:.8rem; color:#10b981; background:#d1fae5; border:1px solid #a7f3d0; padding:.1rem .5rem; border-radius:9999px;">Configured</span>
                        @else
                            <span style="font-size:.8rem; color:#92400e; background:#fef3c7; border:1px solid #fde68a; padding:.1rem .5rem; border-radius:9999px;">Not set</span>
                        @endif
                    </div>
                    <input name="razorpay_webhook_secret" type="password" placeholder="•••••• (leave blank to keep)" style="width:100%; padding:.75rem 1rem; border:1px solid #e5e7eb; border-radius:10px;">
                </div>
            </div>
        </div>

        <div style="margin-top: 1.25rem; display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
            <div>
                <label style="display:block; font-weight:600; color:#374151; margin-bottom:.5rem;">Default Gateway</label>
                <select name="default_gateway" style="width: 100%; max-width: 320px; padding:.8rem 1rem; border:1px solid #e5e7eb; border-radius:10px;">
                    <option value="stripe" {{ $settings->default_gateway === 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="razorpay" {{ $settings->default_gateway === 'razorpay' ? 'selected' : '' }}>Razorpay</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-weight:600; color:#374151; margin-bottom:.5rem;">Currency</label>
                @php $curr = strtoupper($settings->currency ?? config('payment.currency.default','INR')); @endphp
                @if($currencies->isEmpty())
                    <div style="padding:.75rem 1rem; border:1px solid #fee2e2; border-radius:10px; background:#fef2f2; color:#991b1b;">
                        Please seed currencies before configuring payment currency.
                    </div>
                @else
                    <select name="currency" style="width: 100%; max-width: 320px; padding:.8rem 1rem; border:1px solid #e5e7eb; border-radius:10px;">
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->code }}" {{ $curr === $currency->code ? 'selected' : '' }}>
                                {{ $currency->code }} — {{ $currency->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        <div style="margin-top: 1.25rem; display:flex; justify-content:flex-end; gap:.75rem;">
            <button type="submit" style="padding:.8rem 1.25rem; background:#0D0DE0; color:white; border:none; border-radius:10px; font-weight:600; cursor:pointer;">Save Settings</button>
        </div>
    </form>
</x-admin-layout>
