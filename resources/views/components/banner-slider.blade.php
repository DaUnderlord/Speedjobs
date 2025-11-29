@props(['banners'])

@if($banners->count() > 0)
<div x-data="{
    currentSlide: 0,
    banners: {{ $banners->count() }},
    autoplay: null,
    init() {
        this.startAutoplay();
    },
    startAutoplay() {
        this.autoplay = setInterval(() => {
            this.next();
        }, 5000);
    },
    stopAutoplay() {
        clearInterval(this.autoplay);
    },
    next() {
        this.currentSlide = (this.currentSlide + 1) % this.banners;
    },
    prev() {
        this.currentSlide = (this.currentSlide - 1 + this.banners) % this.banners;
    },
    goTo(index) {
        this.currentSlide = index;
        this.stopAutoplay();
        this.startAutoplay();
    }
}" class="relative w-full bg-gradient-to-r from-primary-50 to-accent-50 overflow-hidden" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
    
    <!-- Slides -->
    <div class="relative h-64 md:h-80">
        @foreach($banners as $index => $banner)
            <div x-show="currentSlide === {{ $index }}" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                 class="absolute inset-0"
                 style="display: none;">
                
                <a href="{{ $banner->link ?: '#' }}" class="block h-full" {{ $banner->link ? 'target="_blank"' : '' }}>
                    <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center w-full">
                            <!-- Content -->
                            <div class="text-center md:text-left space-y-4">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    @if($banner->type === 'workshop') bg-blue-100 text-blue-800
                                    @elseif($banner->type === 'training') bg-green-100 text-green-800
                                    @elseif($banner->type === 'event') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($banner->type) }}
                                </span>
                                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                                    {{ $banner->title }}
                                </h2>
                                @if($banner->description)
                                    <p class="text-lg text-gray-600 max-w-xl">
                                        {{ $banner->description }}
                                    </p>
                                @endif
                                @if($banner->link)
                                    <div class="pt-2">
                                        <span class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                                            Learn More
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Image -->
                            @if($banner->image)
                                <div class="hidden md:block">
                                    <img src="{{ asset('storage/' . $banner->image) }}" 
                                         alt="{{ $banner->title }}" 
                                         class="w-full h-64 object-cover rounded-lg shadow-xl">
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Navigation Arrows -->
    @if($banners->count() > 1)
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-lg transition-all z-10">
            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-lg transition-all z-10">
            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
            @foreach($banners as $index => $banner)
                <button @click="goTo({{ $index }})" 
                        :class="currentSlide === {{ $index }} ? 'bg-primary-600 w-8' : 'bg-white/60 w-2'"
                        class="h-2 rounded-full transition-all duration-300">
                </button>
            @endforeach
        </div>
    @endif
</div>
@endif
