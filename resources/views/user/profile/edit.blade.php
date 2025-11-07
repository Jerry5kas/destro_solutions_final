<x-user-layout title="My Profile - Destrosolutions">
    <div>
        <h1 class="page-title">My Profile</h1>

            @if(session('success'))
                <div style="margin-bottom: 1rem; padding: .75rem 1rem; border-radius: 10px; background: #d1fae5; color: #065f46; border:1px solid #a7f3d0;">{{ session('success') }}</div>
            @endif

        <div class="dashboard-card">
            <form method="POST" action="{{ route('user.profile.update') }}">
                @csrf
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Full Name</label>
                        <input name="name" type="text" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none; background: #f9fafb; color: #6b7280;">
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Phone</label>
                        <input name="phone" type="text" value="{{ old('phone', $profile->phone ?? '') }}" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Address</label>
                        <textarea name="address" rows="3" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none; resize: vertical;">{{ old('address', $profile->address ?? '') }}</textarea>
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">City</label>
                        <input name="city" type="text" value="{{ old('city', $profile->city ?? '') }}" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">State</label>
                        <input name="state" type="text" value="{{ old('state', $profile->state ?? '') }}" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Country</label>
                        <input name="country" type="text" value="{{ old('country', $profile->country ?? '') }}" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Postal Code</label>
                        <input name="postal_code" type="text" value="{{ old('postal_code', $profile->postal_code ?? '') }}" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Company</label>
                        <input name="company" type="text" value="{{ old('company', $profile->company ?? '') }}" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Designation</label>
                        <input name="designation" type="text" value="{{ old('designation', $profile->designation ?? '') }}" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight: 600; color: #374151; margin-bottom: .5rem;">Bio</label>
                        <textarea name="bio" rows="3" style="width: 100%; padding: .9rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; font-size: .95rem; outline: none; resize: vertical;">{{ old('bio', $profile->bio ?? '') }}</textarea>
                    </div>
                </div>
                <div style="margin-top:1.5rem; display:flex; justify-content:flex-end;">
                    <button type="submit" style="padding:.75rem 1.5rem; background:#0D0DE0; color:white; border:none; border-radius:10px; font-weight:600; cursor:pointer; transition: all 0.2s ease;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-user-layout>
