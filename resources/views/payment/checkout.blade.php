<x-layout title="Checkout - Destrosolutions">
    <main style="padding: 2rem 1rem; background:#f9fafb; min-height: calc(100vh - 200px);">
        <div style="max-width: 900px; margin: 0 auto;">
            <div style="background:white; border:1px solid #eef2ff; border-radius:16px; box-shadow: 0 10px 30px rgba(13,13,224,0.06);">
                <div style="padding:1.25rem; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; justify-content: space-between;">
                    <h1 style="font-size:1.25rem; font-weight:600; color:#111827;">Checkout</h1>
                    <div style="color:#6b7280; font-size:.9rem;">Training: <span style="font-weight:600; color:#111827;">{{ $training->title }}</span></div>
                </div>
                <div style="padding:1.25rem; display:grid; grid-template-columns: 2fr 1fr; gap: 1.25rem;">
                    <div>
                        @if($gateway === 'stripe')
                            <script src="https://js.stripe.com/v3/"></script>
                            <div style="margin-bottom:1rem;">
                                <div style="font-weight:600; color:#111827; margin-bottom:.25rem;">Stripe Payment</div>
                                <div id="card-element" style="padding: .9rem 1rem; border:1px solid #e5e7eb; border-radius:10px;"></div>
                                <button id="stripe-pay-btn" style="margin-top:.75rem; padding:.8rem 1rem; background:#0D0DE0; color:white; border:none; border-radius:10px; font-weight:600; cursor:pointer;">Pay {{ $training->currency }} {{ number_format((float)($training->price ?? 0), 2) }}</button>
                                <div id="stripe-error" style="color:#b91c1c; margin-top:.5rem; display:none;"></div>
                            </div>
                            <script>
                                (function(){
                                    const stripe = Stripe("{{ $init['public_key'] ?? '' }}");
                                    const elements = stripe.elements();
                                    const card = elements.create('card');
                                    card.mount('#card-element');
                                    const btn = document.getElementById('stripe-pay-btn');
                                    const errorDiv = document.getElementById('stripe-error');
                                    btn.addEventListener('click', async function(){
                                        btn.disabled = true;
                                        const {error, paymentIntent} = await stripe.confirmCardPayment("{{ $init['client_secret'] ?? '' }}", {
                                            payment_method: { card }
                                        });
                                        if (error) {
                                            errorDiv.textContent = error.message;
                                            errorDiv.style.display = 'block';
                                            btn.disabled = false;
                                        } else if (paymentIntent && paymentIntent.status === 'succeeded') {
                                            const url = new URL("{{ route('checkout.success') }}", window.location.origin);
                                            url.searchParams.set('gateway', 'stripe');
                                            url.searchParams.set('payment_id', paymentIntent.id);
                                            window.location.href = url.toString();
                                        } else {
                                            const url = new URL("{{ route('checkout.failed') }}", window.location.origin);
                                            url.searchParams.set('gateway', 'stripe');
                                            window.location.href = url.toString();
                                        }
                                    });
                                })();
                            </script>
                        @elseif($gateway === 'razorpay')
                            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                            <div style="margin-bottom:1rem;">
                                <div style="font-weight:600; color:#111827; margin-bottom:.25rem;">Razorpay Payment</div>
                                <button id="rzp-pay-btn" style="margin-top:.25rem; padding:.8rem 1rem; background:#0D0DE0; color:white; border:none; border-radius:10px; font-weight:600; cursor:pointer;">Pay {{ $training->currency }} {{ number_format((float)($training->price ?? 0), 2) }}</button>
                            </div>
                            <script>
                                (function(){
                                    const options = {
                                        key: "{{ $init['key_id'] ?? '' }}",
                                        amount: {{ (int) round(($training->price ?? 0) * 100) }},
                                        currency: "{{ $training->currency }}",
                                        name: "Destrosolutions",
                                        description: "{{ $training->title }}",
                                        order_id: "{{ $init['order_id'] ?? '' }}",
                                        handler: function (response){
                                            const url = new URL("{{ route('checkout.success') }}", window.location.origin);
                                            url.searchParams.set('gateway', 'razorpay');
                                            url.searchParams.set('razorpay_payment_id', response.razorpay_payment_id);
                                            url.searchParams.set('razorpay_order_id', response.razorpay_order_id);
                                            url.searchParams.set('razorpay_signature', response.razorpay_signature);
                                            window.location.href = url.toString();
                                        },
                                        modal: {
                                            ondismiss: function(){
                                                const url = new URL("{{ route('checkout.failed') }}", window.location.origin);
                                                url.searchParams.set('gateway', 'razorpay');
                                                window.location.href = url.toString();
                                            }
                                        },
                                        theme: { color: '#0D0DE0' }
                                    };
                                    const rzp = new Razorpay(options);
                                    document.getElementById('rzp-pay-btn').onclick = function(e){
                                        rzp.open();
                                        e.preventDefault();
                                    }
                                })();
                            </script>
                        @endif

                        <div style="margin-top: 1rem;">
                            <a href="{{ route('user.dashboard') }}" style="color:#0D0DE0; font-weight:600;">Go to Dashboard</a>
                        </div>
                    </div>
                    <div>
                        <div style="background:#f9fafb; border:1px solid #eef2ff; border-radius:12px; padding:1rem;">
                            <div style="font-weight:600; color:#111827;">Order Summary</div>
                            <div style="margin-top:.5rem; color:#6b7280; font-size:.95rem; display:flex; align-items:center; justify-content: space-between;">
                                <span>{{ $training->title }}</span>
                                <span style="font-weight:600; color:#111827;">{{ $training->currency }} {{ number_format((float)($training->price ?? 0), 2) }}</span>
                            </div>
                            <div style="margin-top:.5rem; color:#6b7280; font-size:.95rem; display:flex; align-items:center; justify-content: space-between;">
                                <span>Taxes</span>
                                <span>Included</span>
                            </div>
                            <div style="margin-top:.75rem; border-top:1px dashed #e5e7eb; padding-top:.75rem; display:flex; align-items:center; justify-content: space-between;">
                                <span style="font-weight:700; color:#111827;">Total</span>
                                <span style="font-weight:700; color:#0D0DE0;">{{ $training->currency }} {{ number_format((float)($training->price ?? 0), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
