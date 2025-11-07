<x-layout title="Destrosolutions - Services">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    <x-banner-page 
        :title="__('Services')" 
        :description="__('Comprehensive security, safety, and SDV services for OEMs and Tier-1s.')"
        imagePath="images/service.png"/>
    
    <!-- Services Intro Section -->
    <section class="relative w-full py-12 md:py-16 lg:py-20 bg-white">
        <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,_0.9fr)_minmax(0,_1fr)] gap-10 lg:gap-16 items-start">
                <div class="space-y-6 services-intro-lead">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-gray-900 leading-tight" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ __('End-to-End Services for Secure, Connected Mobility') }}
                    </h2>
                </div>
                <div class="space-y-6 services-intro-content">
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('We deliver comprehensive security, safety, and Software-Defined Vehicle (SDV) services tailored for OEMs and Tier-1 suppliers. Our teams integrate seamlessly with your engineering programs to embed best practices across cybersecurity, functional safety, and compliance frameworks such as ISO/SAE 21434, ASPICE, and ISO 26262.') }}
                    </p>
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed">
                        {{ __('From chip-to-cloud hardening to OTA release orchestration, we accelerate your SDV roadmap with proven methodologies, specialized accelerators, and managed services that keep your fleets secure, resilient, and launch-ready.') }}
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

    <x-content-items-grid 
        :contentItems="$contentItems" 
        :categories="$categories" 
        :selectedCategory="$selectedCategory"
        contentType="services"
    />
</x-layout>


