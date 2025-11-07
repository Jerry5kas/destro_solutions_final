@props([
    'title' => 'Card Title',
    'description' => 'Card description text goes here.',
    'buttonText' => 'Learn More',
    'buttonLink' => '#',
    'class' => '',
])

<div class="card-1-item rounded-3xl p-6 md:p-8 flex flex-col shadow-sm hover:shadow-md transition-shadow duration-300 {{ $class }}">
    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 card-1-title">
        {{ $title }}
    </h3>
    <p class="text-base text-gray-600 leading-relaxed mb-6 flex-1 card-1-description">
        {{ $description }}
    </p>
    @if($buttonText)
        <a href="{{ $buttonLink }}" class="max-w-max border-2 border-[#0D0DE0] text-[#0D0DE0] px-6 py-2.5 rounded-full hover:bg-[#0D0DE0] hover:text-white transition-colors duration-300 text-sm md:text-base card-1-button">
            {{ $buttonText }}
        </a>
    @endif
</div>

<style>
    .card-1-item {
        opacity: 0;
        will-change: transform, opacity;
        transform: translateY(30px);
    }

    .card-1-item.animated {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
</style>

