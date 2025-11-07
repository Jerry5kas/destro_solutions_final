<x-layout :title="($training->title ?? 'Training') . ' - Destrosolutions'">
    @php
        $available = \App\Services\Payment\PaymentServiceManager::getAvailableGateways();
        $hasStripe = isset($available['stripe']);
        $hasRazorpay = isset($available['razorpay']);
        $userEnrollment = auth()->check() ? \App\Models\Enrollment::where('user_id', auth()->id())->where('training_id', $training->id)->first() : null;
        $isEnrolled = $userEnrollment && $userEnrollment->status === 'paid';
        $paidEnrollments = $training->enrollments()->where('status', 'paid')->count();
        $availableSpots = $training->max_students ? ($training->max_students - $paidEnrollments) : null;
    @endphp

    <!-- Hero Section with Image -->
    <section style="position: relative; background: linear-gradient(135deg, #0D0DE0 0%, #6366f1 100%); min-height: 400px; display: flex; align-items: center; margin-top: -128px; padding-top: 200px;">
        <div style="position: absolute; inset: 0; background: url('{{ $training->image_url }}') center/cover; opacity: 0.15;"></div>
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; width: 100%; position: relative; z-index: 1;">
            <div style="max-width: 800px;">
                @if($training->category)
                <div style="display: inline-block; padding: 0.5rem 1rem; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; margin-bottom: 1rem;">
                    <span style="color: white; font-size: 0.875rem; font-weight: 600;">{{ $training->category->title }}</span>
                </div>
                @endif
                <h1 style="font-size: 3rem; font-weight: 700; color: white; margin-bottom: 1rem; line-height: 1.2;">
                    {{ $training->title }}
                </h1>
                <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; color: rgba(255, 255, 255, 0.9); font-size: 1rem;">
                    @if($training->start_date)
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $training->start_date->format('M d, Y') }}</span>
                    </div>
                    @endif
                    @if($training->duration_days)
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $training->duration_days }} Days</span>
                    </div>
                    @endif
                    @if($training->max_students)
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>{{ $availableSpots ?? $training->max_students }} / {{ $training->max_students }} Spots Available</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main style="background: #f9fafb; padding: 3rem 0; min-height: calc(100vh - 400px);">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            <div style="display: grid; grid-template-columns: 1fr 400px; gap: 2rem; align-items: start;">
                
                <!-- Left Column - Course Details -->
                <div>
                    <!-- Course Overview -->
                    <div style="background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); margin-bottom: 2rem;">
                        <h2 style="font-size: 1.75rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                            <svg width="28" height="28" fill="none" stroke="#0D0DE0" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Course Overview
                        </h2>
                        
                        @if($training->description)
                        <div style="color: #4b5563; font-size: 1.0625rem; line-height: 1.8; white-space: pre-wrap; margin-bottom: 2rem;">
                            {!! nl2br(e($training->description)) !!}
                        </div>
                        @endif

                        <!-- Course Details Grid -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; padding: 1.5rem; background: #f9fafb; border-radius: 16px; margin-bottom: 2rem;">
                            @if($training->start_date)
                            <div>
                                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem; font-weight: 500;">Start Date</div>
                                <div style="font-size: 1.125rem; font-weight: 600; color: #111827;">
                                    {{ $training->start_date->format('M d, Y') }}
                                </div>
                            </div>
                            @endif
                            
                            @if($training->end_date)
                            <div>
                                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem; font-weight: 500;">End Date</div>
                                <div style="font-size: 1.125rem; font-weight: 600; color: #111827;">
                                    {{ $training->end_date->format('M d, Y') }}
                                </div>
                            </div>
                            @endif
                            
                            @if($training->duration_days)
                            <div>
                                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem; font-weight: 500;">Duration</div>
                                <div style="font-size: 1.125rem; font-weight: 600; color: #111827;">
                                    {{ $training->duration_days }} Days
                                </div>
                            </div>
                            @endif
                            
                            @if($training->max_students)
                            <div>
                                <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem; font-weight: 500;">Capacity</div>
                                <div style="font-size: 1.125rem; font-weight: 600; color: #111827;">
                                    {{ $training->max_students }} Students
                                    @if($availableSpots !== null)
                                        <span style="font-size: 0.875rem; color: {{ $availableSpots > 0 ? '#10b981' : '#ef4444' }}; font-weight: 500;">
                                            ({{ $availableSpots }} available)
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Learning Objectives -->
                    @if($training->objective_list && count($training->objective_list) > 0)
                    <div style="background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); margin-bottom: 2rem;">
                        <h2 style="font-size: 1.75rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                            <svg width="28" height="28" fill="none" stroke="#0D0DE0" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Learning Objectives
                        </h2>
                        <div style="display: grid; gap: 1rem;">
                            @foreach($training->objective_list as $index => $obj)
                            <div style="display: flex; align-items: start; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 12px; border-left: 4px solid #0D0DE0;">
                                <div style="flex-shrink: 0; width: 32px; height: 32px; background: #0D0DE0; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">
                                    {{ $index + 1 }}
                                </div>
                                <div style="flex: 1; color: #374151; font-size: 1rem; line-height: 1.6;">
                                    {{ $obj }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- What You'll Learn -->
                    @if($training->description)
                    <div style="background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
                        <h2 style="font-size: 1.75rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                            <svg width="28" height="28" fill="none" stroke="#0D0DE0" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Course Details
                        </h2>
                        <div style="color: #4b5563; font-size: 1.0625rem; line-height: 1.8; white-space: pre-wrap;">
                            {!! nl2br(e($training->description)) !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column - Enrollment Card -->
                <div>
                    <div style="position: sticky; top: 120px; background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12); border: 1px solid #e5e7eb;">
                        <!-- Price -->
                        <div style="margin-bottom: 2rem;">
                            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem; font-weight: 500;">Course Fee</div>
                            <div style="font-size: 2.5rem; font-weight: 700; color: #0D0DE0; margin-bottom: 0.25rem;">
                                {{ $training->currency }} {{ number_format((float)($training->price ?? 0), 2) }}
                            </div>
                            <div style="font-size: 0.875rem; color: #6b7280;">All taxes included</div>
                        </div>

                        <!-- Enrollment Status -->
                        @if($isEnrolled)
                        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 12px; margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                                <svg width="20" height="20" fill="none" stroke="#065f46" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span style="font-weight: 600; color: #065f46;">You are enrolled in this course</span>
                            </div>
                            <div style="font-size: 0.875rem; color: #047857;">
                                Enrolled on {{ $userEnrollment->enrolled_at->format('M d, Y') }}
                            </div>
                            <a href="{{ route('user.dashboard') }}" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border-radius: 10px; font-weight: 600; text-decoration: none; text-align: center; width: 100%;">
                                Go to Dashboard →
                            </a>
                        </div>
                        @else
                        <!-- Enrollment Form -->
                        <form method="POST" action="{{ route('trainings.enroll', $training->slug) }}">
                            @csrf
                            
                            @if ($errors->any())
                            <div style="margin-bottom: 1rem; padding: 1rem; background: #fee2e2; border: 1px solid #fecaca; border-radius: 12px;">
                                <div style="color: #991b1b; font-size: 0.875rem; font-weight: 500;">{{ $errors->first() }}</div>
                            </div>
                            @endif

                            @if(!$training->hasAvailableSpots() && $training->max_students)
                            <div style="margin-bottom: 1rem; padding: 1rem; background: #fef3c7; border: 1px solid #fde68a; border-radius: 12px;">
                                <div style="color: #92400e; font-size: 0.875rem; font-weight: 500;">
                                    ⚠️ This course is full. Please contact us for waitlist options.
                                </div>
                            </div>
                            @endif

                            <!-- Payment Method -->
                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.75rem; font-size: 0.9375rem;">
                                    Payment Method
                                </label>
                                @if($hasStripe || $hasRazorpay)
                                <select name="gateway" required style="width: 100%; padding: 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; background: white; transition: all 0.2s ease; cursor: pointer;" onchange="this.style.borderColor='#0D0DE0'" onblur="this.style.borderColor='#e5e7eb'">
                                    @if($hasStripe)
                                    <option value="stripe">💳 Stripe (Credit/Debit Cards, Wallets)</option>
                                    @endif
                                    @if($hasRazorpay)
                                    <option value="razorpay">💳 Razorpay (UPI, Netbanking, Cards)</option>
                                    @endif
                                </select>
                                @else
                                <div style="padding: 1rem; background: #fee2e2; border: 1px solid #fecaca; border-radius: 12px; color: #991b1b; font-size: 0.875rem;">
                                    No payment gateways are enabled. Please contact support.
                                </div>
                                @endif
                            </div>

                            <!-- Terms & Conditions -->
                            <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f9fafb; border-radius: 12px;">
                                <label style="display: flex; gap: 0.75rem; align-items: flex-start; cursor: pointer;">
                                    <input type="checkbox" name="accept_terms" value="1" required style="margin-top: 0.25rem; width: 20px; height: 20px; accent-color: #0D0DE0; cursor: pointer; flex-shrink: 0;">
                                    <span style="color: #4b5563; font-size: 0.9375rem; line-height: 1.6;">
                                        I agree to the 
                                        <a href="#" style="color: #0D0DE0; font-weight: 600; text-decoration: underline;">Terms & Conditions</a> 
                                        and 
                                        <a href="#" style="color: #0D0DE0; font-weight: 600; text-decoration: underline;">Privacy Policy</a>
                                    </span>
                                </label>
                            </div>

                            <!-- Enroll Button -->
                            @auth
                            <button type="submit" style="width: 100%; padding: 1.125rem 1.5rem; background: linear-gradient(135deg, #0D0DE0 0%, #6366f1 100%); color: white; border: none; border-radius: 12px; font-size: 1.0625rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(13, 13, 224, 0.3);" 
                                    @if(!$hasStripe && !$hasRazorpay) disabled @endif
                                    @if(!$training->hasAvailableSpots() && $training->max_students) disabled @endif
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(13, 13, 224, 0.4)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(13, 13, 224, 0.3)'">
                                Enroll & Continue to Payment
                            </button>
                            @else
                            <div style="text-align: center; padding: 1rem; background: #eff6ff; border-radius: 12px; margin-bottom: 1rem;">
                                <p style="color: #1e40af; font-size: 0.875rem; margin-bottom: 0.75rem;">Please sign in to enroll</p>
                                <div style="display: flex; gap: 0.75rem;">
                                    <a href="{{ route('login') }}" style="flex: 1; padding: 0.875rem; background: #0D0DE0; color: white; border-radius: 10px; font-weight: 600; text-decoration: none; text-align: center; font-size: 0.9375rem;">
                                        Sign In
                                    </a>
                                    <a href="{{ route('register') }}" style="flex: 1; padding: 0.875rem; background: white; color: #0D0DE0; border: 2px solid #0D0DE0; border-radius: 10px; font-weight: 600; text-decoration: none; text-align: center; font-size: 0.9375rem;">
                                        Sign Up
                                    </a>
                                </div>
                            </div>
                            @endauth
                        </form>
                        @endif

                        <!-- Course Info -->
                        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
                            <div style="display: grid; gap: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; color: #6b7280; font-size: 0.875rem;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <span>Secure payment processing</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.75rem; color: #6b7280; font-size: 0.875rem;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Instant enrollment confirmation</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.75rem; color: #6b7280; font-size: 0.875rem;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Access to course materials</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('styles')
    <style>
        @media (max-width: 1024px) {
            section[style*="grid-template-columns: 1fr 400px"] {
                grid-template-columns: 1fr !important;
            }
        }
        
        @media (max-width: 768px) {
            section[style*="font-size: 3rem"] h1 {
                font-size: 2rem !important;
            }
            
            section[style*="padding: 2.5rem"] {
                padding: 1.5rem !important;
            }
        }
    </style>
    @endpush
</x-layout>
