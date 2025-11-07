<x-auth-layout title="Register - Destrosolutions">
    <div style="width: 100%; max-width: 520px; background: white; border-radius: 16px; box-shadow: 0 20px 60px rgba(13,13,224,0.08); border: 1px solid #eef2ff; overflow: hidden;">
            <div style="padding: 2rem 2rem 1rem 2rem; text-align: center;">
                <div class="passero-one-regular" style="font-size: 1.75rem; color: #0D0DE0;">Destrosolutions</div>
                <h1 style="margin-top: .25rem; font-size: 1.25rem; color: #111827; font-weight: 600;">Create your account</h1>
                <p style="margin-top: .25rem; color: #6b7280; font-size: .95rem;">Join training programs and manage your enrollments</p>
            </div>

            <form method="POST" action="{{ route('register') }}" style="padding: 1rem 2rem 2rem 2rem;">
                @csrf
                @if ($errors->any())
                    <div style="margin-bottom: 1rem; padding: .75rem 1rem; border-radius: 10px; background: #fee2e2; color: #991b1b; font-size: .9rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div style="margin-bottom: 1rem;">
                    <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Full Name</label>
                    <input name="name" type="text" value="{{ old('name') }}" required autocomplete="name" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Email</label>
                    <input name="email" type="email" value="{{ old('email') }}" required autocomplete="email" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                </div>

                <div style="margin-bottom: 1rem; display:grid; grid-template-columns: 1fr 1fr; gap: .75rem;">
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Password</label>
                        <input name="password" type="password" required autocomplete="new-password" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Confirm Password</label>
                        <input name="password_confirmation" type="password" required autocomplete="new-password" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                </div>

                <button type="submit" style="width:100%; padding: .9rem 1rem; background:#0D0DE0; color:white; border:none; border-radius: 10px; font-weight:600; cursor:pointer;">Create account</button>

                <p style="margin-top:1rem; text-align:center; color:#6b7280; font-size:.9rem;">Already have an account? <a href="{{ route('login') }}" style="color:#0D0DE0; font-weight:600;">Sign in</a></p>
            </form>
        </div>
</x-auth-layout>
