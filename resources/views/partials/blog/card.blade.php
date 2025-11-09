@php
    $imageLoading = $imageLoading ?? 'lazy';
    $cardClass = isset($cardClass) ? trim('blog-grid-card group ' . $cardClass) : 'blog-grid-card group';
    $cardAttributes = $cardAttributes ?? [];
@endphp
<article class="{{ $cardClass }}"
    @foreach($cardAttributes as $attr => $value)
        @continue($value === null || $value === '')
        {{ $attr }}="{{ e($value) }}"
    @endforeach
>
    <div class="blog-card-image">
        <img 
            src="{{ $post->image_url ?? asset('images/blog.jpeg') }}" 
            alt="{{ $post->title }}"
            loading="{{ $imageLoading }}"
            decoding="{{ $imageLoading === 'eager' ? 'sync' : 'async' }}"
        >
    </div>
    <div class="blog-card-body">
        @if($formatDate($post))
            <span class="blog-card-date">
                {{ $formatDate($post) }}
                @php($typeText = $typeLabel($post))
                @if($typeText)
                    &nbsp;|&nbsp;{{ $typeText }}
                @endif
            </span>
        @endif
        <h3 class="blog-card-title">{{ $post->title }}</h3>
        <a href="{{ $postLink($post) }}" class="blog-card-link">
            {{ __('Learn more') }}
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M5 12h14"></path>
                <path d="M13 6l6 6-6 6"></path>
            </svg>
        </a>
    </div>
    <div class="blog-card-overlay">
        <div class="blog-card-overlay-content">
            @if($categoryTitle($post))
                <span class="blog-card-overlay-category">{{ $categoryTitle($post) }}</span>
            @endif
            @if($formatDate($post))
                <span class="blog-card-overlay-date">
                    {{ $formatDate($post) }} | {{ $typeLabel($post) }}
                </span>
            @endif
            <h3 class="blog-card-overlay-title">{{ $post->title }}</h3>
            @if($post->description)
                <p>{{ $excerpt($post) }}</p>
            @endif
            <a href="{{ $postLink($post) }}" class="blog-card-link">
                {{ __('Learn more') }}
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M5 12h14"></path>
                    <path d="M13 6l6 6-6 6"></path>
                </svg>
            </a>
        </div>
    </div>
</article>

