{{-- 3D Globe Component for Hero Section --}}
<div
    x-data="{ globeReady: false, cleanup: null }"
    x-init="
        // Wait for next tick to ensure DOM is ready
        $nextTick(() => {
            if (typeof window.initGlobe === 'function') {
                cleanup = window.initGlobe('globe-viz', () => {
                    globeReady = true;
                });
            } else {
                console.error('Globe initialization function not found');
            }
        });
    "
    {{ $attributes->merge(['class' => 'absolute inset-0 z-0 overflow-hidden pointer-events-none']) }}
>
    {{-- Globe Container --}}
    <div 
        id="globe-viz" 
        class="w-full h-full flex items-center justify-center transition-opacity duration-1000 ease-in-out"
        :class="globeReady ? 'opacity-100' : 'opacity-0'"
    ></div>
</div>
