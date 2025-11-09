<section class="contact-section relative w-full py-12 md:py-16 bg-white" id="contact" data-contact-section>
    <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-stretch">
            
            <!-- Left Side: Image -->
            <div class="contact-image-wrapper order-2 lg:order-1 h-64 lg:h-full" data-contact-image>
                <div class="relative w-full h-full rounded-lg overflow-hidden shadow-lg">
                    <img 
                        src="https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800&h=600&fit=crop&auto=format" 
                        alt="Contact Us"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0D0DE0]/20 to-transparent"></div>
                </div>
            </div>

            <!-- Right Side: Contact Form -->
            <div class="contact-form-wrapper order-1 lg:order-2 h-64 lg:h-full flex flex-col" data-contact-form>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4" data-contact-heading>
                    {{ __('Get in touch') }}
                </h2>

                <form id="contact-form" class="flex-1 flex flex-col" data-contact-fields>
                    <div class="space-y-3 flex-1" data-contact-inputs>
                        <!-- Name Field -->
                        <div>
                            <label for="contact-name" class="block text-sm font-medium text-gray-700 mb-1.5">
                                {{ __('Name') }}
                            </label>
                            <input 
                                type="text" 
                                id="contact-name" 
                                name="name"
                                placeholder="{{ __('Enter name') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D0DE0] focus:border-transparent transition-all duration-200 text-sm"
                                required
                            />
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="contact-email" class="block text-sm font-medium text-gray-700 mb-1.5">
                                {{ __('Email') }}
                            </label>
                            <input 
                                type="email" 
                                id="contact-email" 
                                name="email"
                                placeholder="{{ __('Enter email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D0DE0] focus:border-transparent transition-all duration-200 text-sm"
                                required
                            />
                        </div>

                        <!-- Mobile Field -->
                        <div>
                            <label for="contact-mobile" class="block text-sm font-medium text-gray-700 mb-1.5">
                                {{ __('Mobile') }}
                            </label>
                            <input 
                                type="tel" 
                                id="contact-mobile" 
                                name="mobile"
                                placeholder="{{ __('Enter mobile') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D0DE0] focus:border-transparent transition-all duration-200 text-sm"
                                required
                            />
                        </div>

                        <!-- Message Field -->
                        <div>
                            <label for="contact-message" class="block text-sm font-medium text-gray-700 mb-1.5">
                                {{ __('Message') }}
                            </label>
                            <textarea 
                                id="contact-message" 
                                name="message"
                                rows="2"
                                placeholder="{{ __('Enter your message') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0D0DE0] focus:border-transparent transition-all duration-200 resize-none text-sm"
                                required
                            ></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2 mt-auto" data-contact-submit>
                        <button 
                            type="submit"
                            class="w-full bg-[#0D0DE0] text-white px-6 py-2.5 rounded-md hover:bg-[#0a0ab3] transition-colors duration-300 font-semibold text-sm md:text-base shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-[0.98]"
                        >
                            {{ __('Request a Consultation') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<style>
    .contact-section {
        position: relative;
        z-index: 1;
    }

    .contact-image-wrapper {
        position: relative;
        min-height: 16rem; /* h-64 fallback */
    }

    .contact-form-wrapper {
        position: relative;
        min-height: 16rem; /* h-64 fallback */
    }

    @media (min-width: 1024px) {
        .contact-image-wrapper,
        .contact-form-wrapper {
            min-height: auto;
        }
    }

    #contact-form input:focus,
    #contact-form textarea:focus {
        border-color: #0D0DE0;
    }

    #contact-form input::placeholder,
    #contact-form textarea::placeholder {
        color: #9CA3AF;
        font-weight: 300;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contact-form');
        const contactSection = document.querySelector('[data-contact-section]');
        const formWrapper = document.querySelector('[data-contact-form]');
        const inputsGroup = document.querySelector('[data-contact-inputs]');
        const submitWrapper = document.querySelector('[data-contact-submit]');
        const heading = document.querySelector('[data-contact-heading]');
        const imageWrapper = document.querySelector('[data-contact-image]');

        const elementsToAnimate = [
            { el: heading, offset: 0 },
            { el: inputsGroup, offset: 0.15 },
            { el: submitWrapper, offset: 0.3 }
        ];

        let hasAnimated = false;

        function runGsapAnimation() {
            if (typeof window.gsap === 'undefined') {
                return false;
            }

            const tl = gsap.timeline({
                defaults: { ease: 'power2.out', duration: 0.8 }
            });

            tl.from(imageWrapper, { opacity: 0, x: -40 })
              .from(formWrapper, { opacity: 0, x: 40 }, '-=0.6')
              .from(elementsToAnimate.map(item => item.el).filter(Boolean), {
                  opacity: 0,
                  y: 30,
                  stagger: 0.2
              }, '-=0.5');

            return true;
        }

        function runFallbackAnimation() {
            const animatedElements = [
                imageWrapper,
                formWrapper,
                ...elementsToAnimate.map(item => item.el).filter(Boolean)
            ];

            animatedElements.forEach((el, index) => {
                if (!el) return;

                el.style.opacity = '0';
                el.style.transform = index === 0 ? 'translateX(-32px)' : 'translateX(32px)';

                requestAnimationFrame(() => {
                    setTimeout(() => {
                        el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                        el.style.opacity = '1';
                        el.style.transform = 'translateX(0)';
                    }, index * 100);
                });
            });
        }

        function animateOnScroll() {
            if (hasAnimated || !contactSection) return;
            hasAnimated = true;

            if (!runGsapAnimation()) {
                runFallbackAnimation();
            }
        }

        if (contactSection) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateOnScroll();
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.25
            });

            observer.observe(contactSection);
        }
        
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = {
                    name: document.getElementById('contact-name').value,
                    email: document.getElementById('contact-email').value,
                    mobile: document.getElementById('contact-mobile').value,
                    message: document.getElementById('contact-message').value
                };
                
                // Here you can add form submission logic
                // For now, just log it
                console.log('Contact form submitted:', formData);
                
                // You can add AJAX call here to submit to your backend
                // Example:
                // fetch('/contact', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                //     },
                //     body: JSON.stringify(formData)
                // })
                
                // Reset form after submission (optional)
                // contactForm.reset();
            });
        }
    });
</script>

