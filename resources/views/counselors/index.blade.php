<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Expert Career Counselors</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Get personalized guidance from industry experts to accelerate your career growth.</p>
            </div>

            <!-- Filters -->
            <div class="mb-8 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('counselors.index') }}" class="px-4 py-2 rounded-full {{ !request('specialization') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} transition shadow-sm">
                    All Counselors
                </a>
                @foreach($specializations as $spec)
                    <a href="{{ route('counselors.index', ['specialization' => $spec]) }}" class="px-4 py-2 rounded-full {{ request('specialization') == $spec ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} transition shadow-sm">
                        {{ $spec }}
                    </a>
                @endforeach
            </div>

            <!-- Counselor Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($counselors as $counselor)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col h-full">
                        <!-- Header/Cover -->
                        <div class="h-24 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                        
                        <!-- Profile Info -->
                        <div class="px-6 pb-6 flex-1 flex flex-col -mt-12">
                            <div class="flex justify-between items-end mb-4">
                                <div class="w-24 h-24 rounded-full border-4 border-white bg-gray-200 overflow-hidden shadow-sm">
                                    @if($counselor->user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $counselor->user->profile_photo_path) }}" alt="{{ $counselor->user->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500 text-2xl font-bold">
                                            {{ substr($counselor->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-green-200">
                                    Available
                                </div>
                            </div>

                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-gray-900">{{ $counselor->user->name }}</h3>
                                <p class="text-blue-600 font-medium text-sm">{{ $counselor->specialization }}</p>
                            </div>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-1 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-medium text-gray-900 mr-1">{{ $counselor->rating }}</span>
                                <span>({{ rand(10, 50) }} reviews)</span>
                            </div>

                            <p class="text-gray-600 text-sm mb-6 line-clamp-3 flex-1">
                                {{ $counselor->bio }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-gray-500 block">Hourly Rate</span>
                                    <span class="text-lg font-bold text-gray-900">₦{{ number_format($counselor->hourly_rate) }}</span>
                                </div>
                                <a href="{{ route('counselors.show', $counselor) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No counselors found</h3>
                        <p class="text-gray-500 mt-1">Try adjusting your filters or check back later.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $counselors->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
