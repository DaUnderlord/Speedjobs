<x-app-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-primary-900 py-24 sm:py-32 overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2830&q=80&blend=111827&sat=-100&exp=15&blend-mode=multiply" alt="" class="w-full h-full object-cover">
            </div>
            <div class="relative max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-heading font-bold tracking-tight text-white sm:text-6xl">About SpeedJobs Africa</h1>
                <p class="mt-6 text-lg leading-8 text-gray-300 max-w-2xl mx-auto">{{ __('content.brand.mission_short') }}</p>
            </div>
        </div>

        <!-- Vision & Mission -->
        <div class="py-24 sm:py-32">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-primary-600 uppercase tracking-wide">Our Vision</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('content.about.vision') }}</p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="py-24 sm:py-32 bg-gray-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center mb-16">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Meet Our Leadership</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">The team driving the vision of SpeedJobs Africa.</p>
                </div>
                <ul role="list" class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                    @php
                        $team = \App\Models\Team::all();
                    @endphp
                    @foreach($team as $member)
                    <li>
                        <div class="flex flex-col gap-6 items-center text-center">
                            <div class="h-40 w-40 rounded-full bg-gray-200 flex items-center justify-center text-4xl font-bold text-gray-400">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900">{{ $member->name }}</h3>
                                <p class="text-sm font-semibold leading-6 text-primary-600">{{ $member->role }}</p>
                                <p class="mt-4 text-sm leading-6 text-gray-600">{{ $member->bio }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
