<x-layout title="Destrosolutions - Software Defined Vehicles">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    <x-banner-page 
        :title="__('Quantum')"
        :description="__('Securing chip-to-cloud in Quantum era.')"
        imagePath="images/quantum.jpeg"/>
   
    <!-- Quantum Intro Section -->
    <section class="relative w-full py-12 md:py-16 lg:py-20 bg-white" style="z-index: 1;">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,_0.9fr)_minmax(0,_1fr)] gap-10 lg:gap-16 items-start">
                <div class="space-y-6 quantum-intro-lead">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-gray-900 leading-tight" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ __('Quantum-Safe Security for Software-Defined Vehicles') }}
                    </h2>
                </div>
                <div class="space-y-6 quantum-intro-content">
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('DestroSolutions helps OEMs, Tier-1 suppliers, and mobility innovators prepare for the post-quantum era. We secure the entire SDV lifecycle—from silicon to cloud—ensuring cryptography, data, and connectivity remain resilient against quantum-scale threats.') }}
                    </p>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('Our quantum readiness frameworks align security architecture, engineering practices, and governance with the pace of innovation, so your connected mobility products ship with confidence today and remain protected tomorrow.') }}
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('contact') }}" class="inline-block border-2 border-[#0D0DE0] text-[#0D0DE0] px-6 py-3 rounded-full hover:bg-[#0D0DE0] hover:text-white transition-colors duration-300 font-medium">
                            {{ __('Talk to an Expert') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-quantum-solution 
        :contentItems="$contentItems"
        :categories="$categories"
        :selectedCategory="$selectedCategory"
    />

</x-layout>