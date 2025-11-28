@php
    use Illuminate\Support\Str;

    $imagePath = $blog->image_url ?? asset('images/blog.jpeg');
    $editorContent = $blog->editor_content ?? [];
@endphp

<x-layout :title="($blog->title ?? 'Blog Post') . ' - Destrosolutions'">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    
    {{-- Banner with centered title --}}
    <section class="relative w-full h-[420px] sm:h-[460px] lg:h-[520px] overflow-hidden">
        <img 
            src="{{ $imagePath }}" 
            alt="{{ $blog->title }}"
            class="absolute inset-0 w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-black"></div>
        <div class="relative h-full max-w-5xl mx-auto px-6 flex items-center justify-center text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                {{ $blog->title }}
            </h1>
        </div>
    </section>

    {{-- Editor Content Section --}}
    @if(!empty($editorContent) && is_array($editorContent))
        <section class="relative w-full py-16 bg-white overflow-hidden">
            <div class="max-w-6xl mx-auto h-auto px-4 md:px-8">
                <article class="blog-content prose prose-lg max-w-none" style="word-wrap: break-word; overflow-wrap: break-word;">
                    @php $blockIndex = 0; @endphp
                    @foreach($editorContent as $block)
                        @php $blockIndex++; @endphp
                        @php
                            $type = $block['type'] ?? null;
                            $style = $block['style'] ?? null;
                            $color = $block['color'] ?? null;
                            $align = $block['align'] ?? null;
                            $size = $block['size'] ?? null;
                            $content = $block['content'] ?? '';
                            $url = $block['url'] ?? null;
                            $urls = $block['urls'] ?? [];
                            $filename = $block['filename'] ?? null;
                        @endphp

                        @switch($type)
                            @case('h1')
                                <h1 class="text-5xl font-bold mb-4 {{ $color ?? '' }}" style="color: {{ $color === 'text-blue-600' ? '#0D0DE0' : ($color === 'text-gray-600' ? '#4b5563' : ($color === 'text-gray-900' ? '#111827' : '#111827')) }}; {{ $align ? 'text-align: ' . $align . ';' : '' }}">{!! $content !!}</h1>
                                @break

                            @case('h2')
                                <h2 class="text-4xl font-bold mb-3 {{ $color ?? '' }}" style="color: {{ $color === 'text-blue-600' ? '#0D0DE0' : ($color === 'text-gray-600' ? '#4b5563' : ($color === 'text-gray-900' ? '#111827' : '#111827')) }}; {{ $align ? 'text-align: ' . $align . ';' : '' }}">{!! $content !!}</h2>
                                @break

                            @case('h3')
                                <h3 class="text-3xl font-semibold mb-2 {{ $color ?? '' }}" style="color: {{ $color === 'text-blue-600' ? '#0D0DE0' : ($color === 'text-gray-600' ? '#4b5563' : ($color === 'text-gray-900' ? '#111827' : '#111827')) }}; {{ $align ? 'text-align: ' . $align . ';' : '' }}">{!! $content !!}</h3>
                                @break

                            @case('h4')
                                <h4 class="text-2xl font-semibold mb-2 {{ $color ?? '' }}" style="color: {{ $color === 'text-blue-600' ? '#0D0DE0' : ($color === 'text-gray-600' ? '#4b5563' : ($color === 'text-gray-900' ? '#111827' : '#111827')) }}; {{ $align ? 'text-align: ' . $align . ';' : '' }}">{!! $content !!}</h4>
                                @break

                            @case('p')
                                <p class="text-base mb-4 {{ $color ?? '' }}" style="color: {{ $color === 'text-blue-600' ? '#0D0DE0' : ($color === 'text-gray-600' ? '#4b5563' : ($color === 'text-gray-900' ? '#111827' : '#111827')) }}; {{ $align ? 'text-align: ' . $align . ';' : '' }}{{ $size ? 'font-size: ' . ($size === 'xs' ? '0.75rem' : ($size === 'sm' ? '0.875rem' : ($size === 'base' ? '1rem' : ($size === 'lg' ? '1.125rem' : '1.25rem')))) . ';' : '' }}">{!! $content !!}</p>
                                @break

                            @case('blockquote')
                                <blockquote class="mb-4 pl-4 italic" style="color: #111827; border-left: 4px solid #0D0DE0; {{ $align ? 'text-align: ' . $align . ';' : '' }}">{!! $content !!}</blockquote>
                                @break

                            @case('container')
                                <div class="max-w-6xl h-auto border border-gray-600 rounded-xl p-5 mb-4 mx-auto {{ $color ?? '' }}" style="{{ $align ? 'text-align: ' . $align . ';' : '' }}">{!! $content !!}</div>
                                @break

                            @case('ul')
                                @if(is_array($content) && count($content) > 0)
                                    <ul class="mb-4 ml-6 list-disc space-y-2" style="color: #111827; {{ $align ? 'text-align: ' . $align . ';' : '' }}">
                                        @foreach($content as $item)
                                            <li>{!! $item !!}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @break

                            @case('ol')
                                @if(is_array($content) && count($content) > 0)
                                    <ol class="mb-4 ml-6 list-decimal space-y-2" style="color: #111827; {{ $align ? 'text-align: ' . $align . ';' : '' }}">
                                        @foreach($content as $item)
                                            <li>{!! $item !!}</li>
                                        @endforeach
                                    </ol>
                                @endif
                                @break

                            @case('code')
                                <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono" style="{{ $align ? 'text-align: ' . $align . ';' : '' }}">{!! $content !!}</code>
                                @break

                            @case('codeblock')
                                <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto mb-4"><code>{!! htmlspecialchars($content) !!}</code></pre>
                                @break

                            @case('divider')
                                <hr class="mb-4 border-t-2 border-gray-300" />
                                @break

                            @case('link')
                                @if($url)
                                    <p class="mb-4">
                                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="underline" style="color: #0D0DE0; text-decoration-color: #0D0DE0;" onmouseover="this.style.color='#0A0AB4'" onmouseout="this.style.color='#0D0DE0'">
                                            {!! $content !!}
                                        </a>
                                    </p>
                                @endif
                                @break

                            @case('file')
                                @if($url)
                                    <div class="mb-4 inline-flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <a href="{{ $url }}" download="{{ $filename }}" class="text-gray-700 font-medium hover:text-gray-900">
                                            {{ $filename ?? 'Download File' }}
                                        </a>
                                    </div>
                                @endif
                                @break

                            @case('feature-image')
                            @case('single-image')
                                @if($url)
                                    <div class="mb-4 w-full overflow-hidden">
                                        <img src="{{ $url }}" alt="Blog image" class="w-full h-48 sm:h-64 md:h-80 object-cover rounded-lg" style="max-width: 100%;">
                                    </div>
                                @endif
                                @break

                            @case('image-grid')
                                @if(!empty($urls) && is_array($urls))
                                    <div class="mb-4 w-full image-grid-wrapper">
                                        <div class="image-grid-container">
                                            @foreach($urls as $imgUrl)
                                                <div class="image-grid-item">
                                                    <img src="{{ $imgUrl }}" alt="Grid image" loading="lazy">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @break

                            @case('image-slider')
                                @if(!empty($urls) && is_array($urls) && count($urls) > 0)
                                    <div class="mb-4 w-full image-slider-wrapper">
                                        <div class="image-slider-container" data-slider-id="slider-{{ $blockIndex }}">
                                            <div class="image-slider-track">
                                                @foreach($urls as $index => $imgUrl)
                                                    <div class="image-slider-slide">
                                                        <img src="{{ $imgUrl }}" alt="Slider image {{ $index + 1 }}" loading="lazy">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if(count($urls) > 1)
                                                <button type="button" class="slider-nav slider-prev" onclick="slideSlider('slider-{{ $blockIndex }}', -1)">‹</button>
                                                <button type="button" class="slider-nav slider-next" onclick="slideSlider('slider-{{ $blockIndex }}', 1)">›</button>
                                                <div class="slider-dots">
                                                    @foreach($urls as $index => $imgUrl)
                                                        <button type="button" class="slider-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide('slider-{{ $blockIndex }}', {{ $index }})"></button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @break

                        @endswitch
                    @endforeach
                </article>
            </div>
        </section>
    @elseif($blog->description)
        {{-- Fallback to description if no editor content --}}
        <section class="relative w-full py-16 bg-white">
            <div class="max-w-6xl mx-auto h-auto px-4 md:px-8">
                <article class="prose prose-lg max-w-none text-gray-700">
                    {!! nl2br(e($blog->description)) !!}
                </article>
            </div>
        </section>
    @endif

    <!-- @if(isset($relatedBlogs) && $relatedBlogs->isNotEmpty())
        <section class="relative w-full pb-20 bg-white py-24">
            <div class="mx-auto max-w-[1280px] px-4 md:px-8">
                <div class="flex items-center justify-between gap-4 mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-900" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">
                        {{ __('Related Blog Posts') }}
                    </h2>
                </div>
                <div id="relatedCardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                    @foreach($relatedBlogs as $index => $related)
                        <article class="group bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col related-card" data-index="{{ $index }}" style="{{ $index < 3 ? '' : 'display:none;' }}">
                            <div class="relative h-48 overflow-hidden">
                                <img 
                                    src="{{ $related->image_url ?? asset('images/blog.jpeg') }}" 
                                    alt="{{ $related->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                @if($related->category?->title)
                                    <span class="absolute bottom-3 left-3 inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-white/90 text-[#0D0DE0] shadow-md">
                                        {{ $related->category->title }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-6 flex flex-col gap-4 flex-1">
                                <div class="text-sm uppercase tracking-wider text-gray-500 font-semibold">
                                    @if($related->date)
                                        {{ $related->date->format('d M Y') }}
                                    @elseif($related->created_at)
                                        {{ $related->created_at->format('d M Y') }}
                                    @endif
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 group-hover:text-[#0D0DE0] transition-colors duration-300">
                                    {{ $related->title }}
                                </h3>
                                @if($related->description)
                                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                                        {{ Str::limit(strip_tags($related->description), 140) }}
                                    </p>
                                @endif
                                <div class="mt-auto pt-2">
                                    <a href="{{ route('blog.show', $related->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#0D0DE0] hover:gap-3 transition-all duration-200">
                                        {{ __('Read More') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M13 6l6 6-6 6"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    @if($relatedBlogs->count() > 3)
                        <div id="relatedSeeMoreCard" class="product-card-item see-more-card" style="display: block;">
                            <button type="button" id="relatedSeeMoreBtn" class="see-more-card-button w-full h-full">
                                <div class="see-more-card-content">
                                    <div class="see-more-icon-wrapper">
                                        <svg class="see-more-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <h3 class="see-more-text">
                                        {{ __('See More') }}
                                    </h3>
                                </div>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif -->

    @push('scripts')
        <script>

            // Related cards "See More" functionality
            document.addEventListener('DOMContentLoaded', function () {
                const container = document.getElementById('relatedCardsContainer');
                const seeMoreBtn = document.getElementById('relatedSeeMoreBtn');

                if (!container) return;

                const cards = Array.from(container.querySelectorAll('.related-card'));
                const batchSize = 3;
                let shownCount = cards.filter(card => card.style.display !== 'none').length;

                function animateCards(targetCards) {
                    if (!targetCards.length) return;

                    if (window.gsap) {
                        window.gsap.fromTo(targetCards, {
                            opacity: 0,
                            y: 36,
                            scale: 0.96
                        }, {
                            opacity: 1,
                            y: 0,
                            scale: 1,
                            duration: 0.75,
                            ease: 'power2.out',
                            stagger: 0.1
                        });
                    } else {
                        targetCards.forEach((card, index) => {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(28px)';
                            requestAnimationFrame(() => {
                                setTimeout(() => {
                                    card.style.transition = 'opacity 0.7s ease-out, transform 0.7s ease-out';
                                    card.style.opacity = '1';
                                    card.style.transform = 'translateY(0)';
                                }, index * 90);
                            });
                        });
                    }
                }

                if (seeMoreBtn) {
                    seeMoreBtn.addEventListener('click', function () {
                        if (this.classList.contains('loading')) return;

                        this.classList.add('loading');

                        const nextCount = Math.min(shownCount + batchSize, cards.length);
                        const cardsToShow = cards.slice(shownCount, nextCount);

                        setTimeout(() => {
                            cardsToShow.forEach(card => {
                                card.style.display = '';
                            });

                            animateCards(cardsToShow);

                            shownCount = nextCount;

                            if (shownCount >= cards.length) {
                                const wrapper = document.getElementById('relatedSeeMoreCard');
                                if (wrapper) {
                                    wrapper.style.display = 'none';
                                } else {
                                    seeMoreBtn.style.display = 'none';
                                }
                            }

                            this.classList.remove('loading');
                        }, 180);
                    });
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .blog-content {
                font-family: 'Montserrat', sans-serif;
                word-wrap: break-word;
                overflow-wrap: break-word;
                max-width: 100%;
                overflow-x: hidden;
                color: #111827;
            }


            .blog-content h1,
            .blog-content h2,
            .blog-content h3,
            .blog-content h4 {
                font-family: 'Montserrat', sans-serif;
                word-wrap: break-word;
                overflow-wrap: break-word;
                max-width: 100%;
                color: #111827;
            }

            /* Ensure color classes override default colors - Blue only when explicitly selected */
            .blog-content h1.text-blue-600,
            .blog-content h2.text-blue-600,
            .blog-content h3.text-blue-600,
            .blog-content h4.text-blue-600,
            .blog-content p.text-blue-600,
            .blog-content .text-blue-600,
            .blog-content [data-color="text-blue-600"],
            .blog-content [data-color="text-blue-600"] * {
                color: #0D0DE0 !important;
            }

            .blog-content h1.text-gray-600,
            .blog-content h2.text-gray-600,
            .blog-content h3.text-gray-600,
            .blog-content h4.text-gray-600,
            .blog-content p.text-gray-600,
            .blog-content .text-gray-600,
            .blog-content [data-color="text-gray-600"],
            .blog-content [data-color="text-gray-600"] * {
                color: #4b5563 !important;
            }

            .blog-content .text-gray-900,
            .blog-content [data-color="text-gray-900"],
            .blog-content [data-color="text-gray-900"] * {
                color: #111827 !important;
            }

            .blog-content p {
                line-height: 1.75;
                word-wrap: break-word;
                overflow-wrap: break-word;
                max-width: 100%;
                color: #111827;
            }

            .blog-content ul,
            .blog-content ol {
                line-height: 1.75;
                word-wrap: break-word;
                overflow-wrap: break-word;
                max-width: 100%;
                color: #111827;
            }

            /* Bold, italic, underline formatting - inherit parent color */
            .blog-content b,
            .blog-content strong {
                font-weight: 700;
            }

            .blog-content i,
            .blog-content em {
                font-style: italic;
            }

            .blog-content u {
                text-decoration: underline;
            }

            /* Links should always be blue */
            .blog-content a {
                color: #0D0DE0;
                text-decoration: underline;
                text-decoration-color: #0D0DE0;
            }

            .blog-content a:hover {
                color: #0A0AB4;
                text-decoration-color: #0A0AB4;
            }


            /* Overall Page Responsiveness */
            @media (max-width: 640px) {
                .blog-content {
                    padding: 0 0.5rem;
                }

                .blog-content h1 {
                    font-size: 1.75rem;
                    line-height: 1.3;
                }

                .blog-content h2 {
                    font-size: 1.5rem;
                    line-height: 1.3;
                }

                .blog-content h3 {
                    font-size: 1.25rem;
                    line-height: 1.4;
                }

                .blog-content h4 {
                    font-size: 1.125rem;
                    line-height: 1.4;
                }

                .blog-content p {
                    font-size: 0.9375rem;
                    line-height: 1.6;
                }

                .blog-content img {
                    max-width: 100%;
                    height: auto;
                }

            }

            @media (min-width: 641px) and (max-width: 1024px) {
                .blog-content h1 {
                    font-size: 2.25rem;
                }

                .blog-content h2 {
                    font-size: 1.875rem;
                }

                .blog-content h3 {
                    font-size: 1.5rem;
                }

            }

            /* Ensure all images are responsive */
            .blog-content img {
                max-width: 100%;
                height: auto;
            }



            .blog-content img {
                max-width: 100%;
                height: auto;
            }


            .related-card {
                border-radius: 32px;
            }

            .see-more-card {
                border: 2px dashed #0D0DE0;
                background: #ffffff;
                cursor: pointer;
                transition: all 0.3s ease;
                border-radius: 32px;
                display: flex;
                align-items: stretch;
                min-height: 100%;
            }

            .see-more-card:hover {
                border-color: #0D0DE0;
                background: #f8f9ff;
                transform: translateY(-6px);
                box-shadow: 0 22px 46px -24px rgba(13, 13, 224, 0.35);
            }

            .see-more-card-button {
                background: transparent;
                border: none;
                padding: 0;
                width: 100%;
                height: 100%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .see-more-card-content {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 2rem 1.5rem;
                width: 100%;
                min-height: 100%;
                gap: 1.25rem;
            }

            .see-more-icon-wrapper {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                border: 2px solid #0D0DE0;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .see-more-card:hover .see-more-icon-wrapper {
                background: #0D0DE0;
                transform: scale(1.08);
            }

            .see-more-card-icon {
                width: 32px;
                height: 32px;
                color: #0D0DE0;
                transition: all 0.3s ease;
            }

            .see-more-card:hover .see-more-card-icon {
                color: #ffffff;
                transform: rotate(90deg);
            }

            .see-more-text {
                font-size: 1.25rem;
                font-weight: 700;
                color: #0D0DE0;
                margin: 0;
                transition: color 0.3s ease;
            }

            /* Image Grid Styles */
            .image-grid-wrapper {
                width: 100%;
                margin: 1.5rem 0;
            }

            .image-grid-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                width: 100%;
            }

            .image-grid-item {
                position: relative;
                height: 14rem;
                width: 100%;
                overflow: hidden;
                border-radius: 0.5rem;
                background: #f3f4f6;
            }

            .image-grid-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
                transition: transform 0.3s ease;
            }

            .image-grid-item:hover img {
                transform: scale(1.05);
            }

            /* Responsive Grid */
            @media (max-width: 640px) {
                .image-grid-container {
                    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                    gap: 0.75rem;
                }
                
                .image-grid-item {
                    height: 12rem;
                }
            }

            @media (min-width: 641px) and (max-width: 1024px) {
                .image-grid-container {
                    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                }
            }

            @media (min-width: 1025px) {
                .image-grid-container {
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                }
            }

            /* Image Slider Styles */
            .image-slider-wrapper {
                width: 100%;
                margin: 1.5rem 0;
            }

            .image-slider-container {
                position: relative;
                width: 100%;
                height: 28rem;
                overflow: hidden;
                border-radius: 0.5rem;
                background: #f3f4f6;
            }

            .image-slider-track {
                display: flex;
                height: 100%;
                transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .image-slider-slide {
                flex: 0 0 100%;
                width: 100%;
                height: 100%;
                position: relative;
            }

            .image-slider-slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .slider-nav {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 2.5rem;
                height: 2.5rem;
                background: rgba(255, 255, 255, 0.9);
                border: none;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                font-weight: bold;
                color: #1f2937;
                z-index: 20;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
                transition: all 0.3s;
            }

            .slider-nav:hover {
                background: rgba(255, 255, 255, 1);
                transform: translateY(-50%) scale(1.1);
            }

            .slider-prev {
                left: 1rem;
            }

            .slider-next {
                right: 1rem;
            }

            .slider-dots {
                position: absolute;
                bottom: 1rem;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 0.5rem;
                z-index: 20;
            }

            .slider-dot {
                width: 0.625rem;
                height: 0.625rem;
                border-radius: 50%;
                border: none;
                padding: 0;
                background: rgba(255, 255, 255, 0.5);
                cursor: pointer;
                transition: all 0.3s;
            }

            .slider-dot.active {
                background: rgba(255, 255, 255, 1);
                width: 0.75rem;
                height: 0.75rem;
            }

            .slider-dot:hover {
                background: rgba(255, 255, 255, 0.8);
            }

            /* Responsive Slider */
            @media (max-width: 640px) {
                .image-slider-container {
                    height: 18rem;
                }
                
                .slider-nav {
                    width: 2rem;
                    height: 2rem;
                    font-size: 1.25rem;
                }
                
                .slider-prev {
                    left: 0.5rem;
                }
                
                .slider-next {
                    right: 0.5rem;
                }
            }

            @media (min-width: 641px) and (max-width: 1024px) {
                .image-slider-container {
                    height: 22rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Slider functionality
            window.sliderStates = window.sliderStates || {};

            function slideSlider(sliderId, direction) {
                const slider = document.querySelector(`[data-slider-id="${sliderId}"]`);
                if (!slider) return;
                
                const slides = slider.querySelectorAll('.image-slider-slide');
                const totalSlides = slides.length;
                if (totalSlides === 0) return;
                
                if (!window.sliderStates[sliderId]) window.sliderStates[sliderId] = 0;
                window.sliderStates[sliderId] = (window.sliderStates[sliderId] + direction + totalSlides) % totalSlides;
                
                updateSlider(sliderId);
            }
            
            function goToSlide(sliderId, index) {
                window.sliderStates[sliderId] = index;
                updateSlider(sliderId);
            }
            
            function updateSlider(sliderId) {
                const slider = document.querySelector(`[data-slider-id="${sliderId}"]`);
                if (!slider) return;
                
                const sliderTrack = slider.querySelector('.image-slider-track');
                const dots = slider.querySelectorAll('.slider-dot');
                const currentIndex = window.sliderStates[sliderId] || 0;
                
                if (sliderTrack) {
                    const translateX = -currentIndex * 100;
                    sliderTrack.style.transform = `translateX(${translateX}%)`;
                }
                
                dots.forEach((dot, i) => {
                    if (i === currentIndex) {
                        dot.classList.add('active');
                        dot.style.background = 'rgba(255, 255, 255, 1)';
                        dot.style.width = '0.75rem';
                        dot.style.height = '0.75rem';
                    } else {
                        dot.classList.remove('active');
                        dot.style.background = 'rgba(255, 255, 255, 0.5)';
                        dot.style.width = '0.625rem';
                        dot.style.height = '0.625rem';
                    }
                });
            }

            // Initialize all sliders on page load
            document.addEventListener('DOMContentLoaded', function() {
                const sliders = document.querySelectorAll('.image-slider-container');
                sliders.forEach(slider => {
                    const sliderId = slider.getAttribute('data-slider-id');
                    if (sliderId) {
                        window.sliderStates[sliderId] = 0;
                        updateSlider(sliderId);
                    }
                });
            });
        </script>
    @endpush
</x-layout>
