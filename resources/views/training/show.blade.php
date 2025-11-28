<x-layout :title="($training->title ?? 'Training') . ' - Destrosolutions'">
    @php
        $available = \App\Services\Payment\PaymentServiceManager::getAvailableGateways();
        $hasStripe = isset($available['stripe']);
        $hasRazorpay = isset($available['razorpay']);
        $userEnrollment = auth()->check()
            ? \App\Models\Enrollment::where('user_id', auth()->id())->where('training_id', $training->id)->first()
            : null;
        $isEnrolled = $userEnrollment && $userEnrollment->status === 'paid';
        $paidEnrollments = $training->enrollments()->where('status', 'paid')->count();
        $availableSpots = $training->max_students ? max(0, $training->max_students - $paidEnrollments) : null;
        $currencyCode = $training->resolvedCurrencyCode();
        $formattedPrice = \App\Support\Money::format($training->price, $currencyCode);
        $isAdminUser = auth()->check() && auth()->user()->isAdmin();
    @endphp

    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>

    <section class="relative isolate overflow-hidden bg-slate-950">
        <img src="{{ $training->image_url }}" alt="{{ $training->title }}" class="absolute inset-0 h-full w-full object-cover opacity-35">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-indigo-900/70"></div>
        <div class="relative mx-auto flex max-w-6xl flex-col gap-6 px-6 py-16 text-white lg:py-20">
            @if($training->category)
                <span class="max-w-max rounded-full border border-white/30 bg-white/10 px-4 py-1 text-sm font-semibold uppercase tracking-wide backdrop-blur">
                    {{ $training->category->title }}
                </span>
            @endif
            <h1 class="text-3xl font-semibold leading-tight tracking-tight md:text-4xl lg:text-5xl">
                {{ $training->title }}
            </h1>
            <div class="flex flex-wrap gap-4 text-sm font-medium text-white/80">
                @if($training->start_date)
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 backdrop-blur">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $training->start_date->format('M d, Y') }}
                    </span>
                @endif
                @if($training->duration_days)
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 backdrop-blur">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $training->duration_days }} {{ __('days') }}
                    </span>
                @endif
                @if($training->max_students)
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 backdrop-blur">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if($availableSpots !== null)
                            {{ $availableSpots }} {{ __('spots left') }}
                        @else
                            {{ __('Flexible cohort size') }}
                        @endif
                    </span>
                @endif
                @if($training->level)
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 backdrop-blur">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ \Illuminate\Support\Str::title($training->level) }}
                    </span>
                @endif
                @if($training->language)
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 backdrop-blur">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m0 14v2m6-6H3" />
                        </svg>
                        {{ \Illuminate\Support\Str::upper($training->language) }}
                    </span>
                @endif
                @if($training->delivery_mode)
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 backdrop-blur">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12l-8-4-8 4m0 0l8 4 8-4m-16 0v6l8 4 8-4v-6" />
                        </svg>
                        {{ \Illuminate\Support\Str::title($training->delivery_mode) }}
                    </span>
                @endif
            </div>
        </div>
    </section>

    <main class="bg-slate-50 pt-40 py-20">
        <div class="relative mx-auto -mt-12 max-w-6xl px-6 lg:-mt-16">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,2fr)_minmax(280px,1fr)]">
                <section class="space-y-8">
                    <article class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                        <header class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">
                            <span>{{ __('Course Overview') }}</span>
                            <span class="h-px flex-1 bg-indigo-100"></span>
                        </header>
                        @if($training->description)
                            <div class="prose prose-lg mt-6 max-w-none text-slate-600">
                                {!! nl2br(e($training->description)) !!}
                            </div>
                        @endif
                        <dl class="mt-10 grid gap-6 sm:grid-cols-2">
                            @if($training->start_date)
                                <div class="rounded-2xl border border-slate-100 p-4">
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Start date') }}</dt>
                                    <dd class="mt-2 text-lg font-semibold text-slate-900">{{ $training->start_date->format('M d, Y') }}</dd>
                                </div>
                            @endif
                            @if($training->end_date)
                                <div class="rounded-2xl border border-slate-100 p-4">
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('End date') }}</dt>
                                    <dd class="mt-2 text-lg font-semibold text-slate-900">{{ $training->end_date->format('M d, Y') }}</dd>
                                </div>
                            @endif
                            @if($training->duration_days)
                                <div class="rounded-2xl border border-slate-100 p-4">
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Duration') }}</dt>
                                    <dd class="mt-2 text-lg font-semibold text-slate-900">{{ $training->duration_days }} {{ __('days') }}</dd>
                                </div>
                            @endif
                            @if($training->duration_hours)
                                <div class="rounded-2xl border border-slate-100 p-4">
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Total hours') }}</dt>
                                    <dd class="mt-2 text-lg font-semibold text-slate-900">{{ $training->duration_hours }} {{ __('hours') }}</dd>
                                </div>
                            @endif
                            @if($training->session_count)
                                <div class="rounded-2xl border border-slate-100 p-4">
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Sessions') }}</dt>
                                    <dd class="mt-2 text-lg font-semibold text-slate-900">{{ $training->session_count }}</dd>
                                </div>
                            @endif
                            @if($training->session_length_minutes)
                                <div class="rounded-2xl border border-slate-100 p-4">
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Session length') }}</dt>
                                    <dd class="mt-2 text-lg font-semibold text-slate-900">{{ $training->session_length_minutes }} {{ __('minutes') }}</dd>
                                </div>
                            @endif
                            @if($training->max_students)
                                <div class="rounded-2xl border border-slate-100 p-4">
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Capacity') }}</dt>
                                    <dd class="mt-2 text-lg font-semibold text-slate-900">
                                        {{ $training->max_students }}
                                        @if(!is_null($availableSpots))
                                            <span class="{{ $availableSpots > 0 ? 'text-emerald-500' : 'text-rose-500' }} text-sm font-semibold">
                                                ({{ $availableSpots }} {{ __('available') }})
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </article>

                    @if($training->objective_list && count($training->objective_list) > 0)
                        <article class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                            <header class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">
                                <span>{{ __('Key Objectives') }}</span>
                                <span class="h-px flex-1 bg-indigo-100"></span>
                            </header>
                            <ul class="mt-6 space-y-4">
                                @foreach($training->objective_list as $objective)
                                    <li class="flex items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50/70 p-4">
                                        <span class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-500 text-white">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        <p class="text-sm text-slate-700">{{ $objective }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </article>
                    @endif

                    @if($training->prerequisites)
                        <article class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                            <header class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">
                                <span>{{ __('Prerequisites') }}</span>
                                <span class="h-px flex-1 bg-indigo-100"></span>
                            </header>
                            <div class="mt-6 space-y-3 text-sm text-slate-600">
                                @foreach(preg_split("/\r\n|\n|\r/", $training->prerequisites) as $line)
                                    @if(trim($line) !== '')
                                        <p>• {{ trim($line) }}</p>
                                    @endif
                                @endforeach
                            </div>
                        </article>
                    @endif

                    @if($training->outcomes)
                        <article class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                            <header class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">
                                <span>{{ __('Learning Outcomes') }}</span>
                                <span class="h-px flex-1 bg-indigo-100"></span>
                            </header>
                            <ul class="mt-6 space-y-4">
                                @foreach($training->outcomes as $outcome)
                                    <li class="flex items-start gap-3 text-sm text-slate-700">
                                        <span class="mt-0.5 h-2.5 w-2.5 rounded-full bg-indigo-500"></span>
                                        <span>{{ $outcome }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </article>
                    @endif

                    @if($training->materials_provided)
                        <article class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                            <header class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">
                                <span>{{ __('Materials Provided') }}</span>
                                <span class="h-px flex-1 bg-indigo-100"></span>
                            </header>
                            <ul class="mt-6 space-y-3 text-sm text-slate-700">
                                @foreach($training->materials_provided as $material)
                                    <li class="flex items-center gap-3">
                                        <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $material }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </article>
                    @endif

                    @if($training->instructor_name || $training->instructor_bio)
                        <article class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                            <header class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">
                                <span>{{ __('Instructor') }}</span>
                                <span class="h-px flex-1 bg-indigo-100"></span>
                            </header>
                            <div class="mt-6 space-y-3">
                                @if($training->instructor_name)
                                    <p class="text-lg font-semibold text-slate-900">{{ $training->instructor_name }}</p>
                                @endif
                                @if($training->instructor_bio)
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ $training->instructor_bio }}</p>
                                @endif
                            </div>
                        </article>
                    @endif

                    @if($training->certification_available || $training->certification_details)
                        <article class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                            <header class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">
                                <span>{{ __('Certification') }}</span>
                                <span class="h-px flex-1 bg-indigo-100"></span>
                            </header>
                            <div class="mt-6 space-y-3 text-sm text-slate-700">
                                <p class="flex items-center gap-2 font-semibold {{ $training->certification_available ? 'text-emerald-600' : 'text-slate-500' }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $training->certification_available ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}" />
                                    </svg>
                                    {{ $training->certification_available ? __('Certificate issued upon completion') : __('No certification provided') }}
                                </p>
                                @if($training->certification_details)
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ $training->certification_details }}</p>
                                @endif
                            </div>
                        </article>
                    @endif

                    @if($training->content)
                        <article class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-100">
                            <header class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-500">
                                <span>{{ __('More Details') }}</span>
                                <span class="h-px flex-1 bg-indigo-100"></span>
                            </header>
                            <div class="prose prose-lg mt-6 max-w-none text-slate-600">
                                {!! $training->content !!}
                            </div>
                        </article>
                    @endif
                </section>

                <aside class="space-y-6 lg:space-y-8 lg:sticky lg:top-24">
                    <div class="rounded-3xl bg-white p-6 shadow-xl ring-1 ring-slate-100">
                        <div class="space-y-1.5">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('Course fee') }}</p>
                            @if(!empty($formattedPrice))
                                <p class="text-3xl font-semibold text-indigo-600">
                                    {{ $formattedPrice }}
                                </p>
                            @else
                                <p class="text-sm font-medium text-slate-500">{{ __('Contact us for pricing') }}</p>
                            @endif
                            <p class="text-xs text-slate-400">{{ __('All taxes included') }}</p>
                        </div>

                        @if($isEnrolled)
                            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                                <div class="flex items-center gap-2 font-semibold">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('You are enrolled in this training') }}
                                </div>
                                <p class="mt-2 text-emerald-600/80 text-xs">
                                    {{ __('Enrolled on') }} {{ $userEnrollment->enrolled_at->format('M d, Y') }}
                                </p>
                                <a href="{{ route('user.dashboard') }}" class="mt-4 inline-flex w-full justify-center rounded-2xl bg-emerald-500 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600">
                                    {{ __('Go to dashboard') }}
                                </a>
                            </div>
                        @else
                            <form method="POST" action="{{ route('training.enroll', $training->slug) }}" class="mt-6 space-y-6" @if(!$isAdminUser) data-restricted-form="true" @endif>
                                @csrf

                                @if ($errors->any())
                                    <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-600">
                                        {{ $errors->first() }}
                                    </div>
                                @endif

                                @if(!$training->hasAvailableSpots() && $training->max_students)
                                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-700">
                                        {{ __('This cohort is currently full. Please contact us to join the waitlist.') }}
                                    </div>
                                @endif

                                <div class="space-y-2">
                                    <label class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">
                                        {{ __('Payment method') }}
                                    </label>
                                    @if($hasStripe || $hasRazorpay)
                                        <select name="gateway" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                            @if($hasStripe)
                                                <option value="stripe">💳 Stripe &mdash; {{ __('Cards, wallets') }}</option>
                                            @endif
                                            @if($hasRazorpay)
                                                <option value="razorpay">💳 Razorpay &mdash; {{ __('UPI, netbanking, cards') }}</option>
                                            @endif
                                        </select>
                                    @else
                                        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-600">
                                            {{ __('Payments are temporarily unavailable. Please contact support.') }}
                                        </div>
                                    @endif
                                </div>

                                <label class="flex items-start gap-3 rounded-2xl bg-slate-50 p-4 text-sm text-slate-600">
                                    <input type="checkbox" name="accept_terms" value="1" required class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-500 focus:ring-indigo-500" />
                                    <span>
                                        {!! __('I agree to the :terms and :privacy', [
                                            'terms' => '<a href="#" class="font-semibold text-indigo-600 underline">'.__('Terms & Conditions').'</a>',
                                            'privacy' => '<a href="#" class="font-semibold text-indigo-600 underline">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </span>
                                </label>

                                @auth
                                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-500 to-indigo-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-60"
                                        @if(!$hasStripe && !$hasRazorpay) disabled @endif
                                        @if(!$training->hasAvailableSpots() && $training->max_students) disabled @endif
                                        @if(!$isAdminUser) data-restricted-action="true" @endif>
                                        {{ __('Enroll & continue to payment') }}
                                    </button>
                                @else
                                    <div class="rounded-2xl border border-indigo-100 bg-indigo-50/70 p-4 text-center text-sm text-indigo-700">
                                        <p class="mb-3 font-medium">{{ __('Please sign in to enroll in this training.') }}</p>
                                        <div class="flex gap-3">
                                            <button type="button" class="restricted-action-btn flex-1 rounded-2xl bg-indigo-500 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-600" data-restricted-action="true" onclick="if(typeof showAdminContactAlert === 'function') { showAdminContactAlert(event); } else { alert('Please contact the administrator for more details.'); } return false;">
                                                {{ __('Sign in') }}
                                            </button>
                                            <button type="button" class="restricted-action-btn flex-1 rounded-2xl border border-indigo-500 py-2.5 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-500 hover:text-white" data-restricted-action="true" onclick="if(typeof showAdminContactAlert === 'function') { showAdminContactAlert(event); } else { alert('Please contact the administrator for more details.'); } return false;">
                                                {{ __('Create account') }}
                                            </button>
                                        </div>
                                    </div>
                                @endauth
                            </form>
                        @endif

                        <ul class="mt-6 space-y-3 text-sm text-slate-600">
                            <li class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Secure payment processing') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Instant enrollment confirmation') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                {{ __('Access to course materials and cohort discussions') }}
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </main>
</x-layout>

@push('scripts')
    <script>
        const isAdmin = @json($isAdminUser ?? false);
        const adminContactMessage = 'Please contact the administrator for more details.';
        
        // Create notification element (global function)
        function showAdminContactAlert(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
                event.stopImmediatePropagation();
            }
            
            if (isAdmin) {
                return true; // Allow admins to proceed
            }
            
            // Remove existing notification if any
            const existing = document.getElementById('admin-contact-notification');
            if (existing) {
                existing.remove();
            }
            
            // Create notification element
            const notification = document.createElement('div');
            notification.id = 'admin-contact-notification';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 16px 32px;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                z-index: 100000;
                font-weight: 500;
                font-size: 15px;
                text-align: center;
                max-width: 90%;
                animation: slideDown 0.3s ease-out;
            `;
            notification.textContent = adminContactMessage;
            
            // Add animation styles if not already added
            if (!document.getElementById('notification-styles')) {
                const style = document.createElement('style');
                style.id = 'notification-styles';
                style.textContent = `
                    @keyframes slideDown {
                        from {
                            opacity: 0;
                            transform: translateX(-50%) translateY(-20px);
                        }
                        to {
                            opacity: 1;
                            transform: translateX(-50%) translateY(0);
                        }
                    }
                    @keyframes fadeOut {
                        from {
                            opacity: 1;
                            transform: translateX(-50%) translateY(0);
                        }
                        to {
                            opacity: 0;
                            transform: translateX(-50%) translateY(-20px);
                        }
                    }
                `;
                document.head.appendChild(style);
            }
            
            document.body.appendChild(notification);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                notification.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 4000);
            
            return false;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Training page script loaded. isAdmin:', isAdmin);
            
            // Only run restriction logic for non-admin users
            if (!isAdmin) {
                // Handle button clicks via event listeners (backup to onclick)
                const restrictedClicks = document.querySelectorAll('[data-restricted-action="true"]');
                console.log('Found restricted buttons:', restrictedClicks.length);
                
                restrictedClicks.forEach((el, index) => {
                    console.log('Attaching listener to button', index, el);
                    el.addEventListener('click', function(event) {
                        console.log('Button clicked via listener!');
                        showAdminContactAlert(event);
                    }, true); // Use capture phase
                });

                // Handle form submissions
                const restrictedForms = document.querySelectorAll('[data-restricted-form="true"]');
                console.log('Found restricted forms:', restrictedForms.length);
                
                restrictedForms.forEach((form) => {
                    form.addEventListener('submit', function(event) {
                        console.log('Form submitted!');
                        showAdminContactAlert(event);
                    }, true); // Use capture phase
                });
            } else {
                console.log('User is admin, restrictions not applied');
            }
        });
    </script>
@endpush

