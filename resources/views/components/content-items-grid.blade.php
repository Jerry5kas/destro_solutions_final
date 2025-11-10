@props([
    'contentItems' => [],
    'categories' => [],
    'selectedCategory' => null,
    'contentType' => 'quantum',
])

@php
    $routeName = match($contentType) {
        'quantum' => 'quantum',
        'services' => 'services',
        'products' => 'products',
        'training' => 'training',
        default => 'quantum',
    };
@endphp

<section class="relative w-full py-12 md:py-16 bg-white">
    <div class="mx-auto max-w-[1280px] px-4 md:px-8 w-full">
        
        <!-- Category Filter -->
        @if($categories->count() > 0)
            <div class="mb-8">
                <div class="flex flex-wrap gap-3">
                    <a 
                        href="{{ route($routeName) }}" 
                        class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ !$selectedCategory ? 'bg-[#0D0DE0] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                    >
                        {{ __('All') }}
                    </a>
                    @foreach($categories as $category)
                        <a 
                            href="{{ route($routeName, ['category' => $category->slug]) }}" 
                            class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ $selectedCategory && $selectedCategory->id === $category->id ? 'bg-[#0D0DE0] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                        >
                            {{ $category->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Content Items Grid -->
        @if($contentItems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($contentItems as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                        @if($item->image_url)
                            <div class="h-48 overflow-hidden">
                                <img 
                                    src="{{ $item->image_url }}" 
                                    alt="{{ $item->title }}"
                                    class="w-full h-full object-cover hover:scale-110 transition-transform duration-300"
                                />
                            </div>
                        @endif
                        <div class="p-6">
                            @if($item->category)
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-[#0D0DE0] bg-[#0D0DE0]/10 rounded-full mb-3">
                                    {{ $item->category->title }}
                                </span>
                            @endif
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                                {{ $item->title }}
                            </h3>
                            @if($item->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($item->description), 120) }}
                                </p>
                            @endif
                            @if($contentType === 'training')
                                <a 
                                    href="{{ route('training.show', $item->slug) }}" 
                                    class="inline-flex items-center text-[#0D0DE0] font-semibold text-sm hover:underline"
                                >
                                    {{ __('Learn More') }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <a 
                                    href="{{ route($routeName, ['category' => $item->category->slug ?? null]) }}" 
                                    class="inline-flex items-center text-[#0D0DE0] font-semibold text-sm hover:underline"
                                >
                                    {{ __('Learn More') }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">{{ __('No items found') }}</p>
                @if($selectedCategory)
                    <a href="{{ route($routeName) }}" class="mt-4 inline-block text-[#0D0DE0] hover:underline">
                        {{ __('View all items') }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

