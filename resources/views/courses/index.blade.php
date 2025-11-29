<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Explore Our Courses</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Upgrade your skills with our expert-led courses. From beginner to advanced, we have something for everyone.</p>
            </div>

            <!-- Filters -->
            <div class="mb-8 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('courses.index') }}" class="px-4 py-2 rounded-full {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} transition shadow-sm">
                    All Courses
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('courses.index', ['category' => $category->slug]) }}" class="px-4 py-2 rounded-full {{ request('category') == $category->slug ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} transition shadow-sm">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Course Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($courses as $course)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col h-full">
                        <!-- Thumbnail -->
                        <div class="relative h-48 bg-gray-200">
                            @if($course->thumbnail_image)
                                <img src="{{ asset('storage/' . $course->thumbnail_image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full bg-blue-50 text-blue-200">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-gray-800 shadow-sm">
                                @if(auth()->user() && auth()->user()->is_paid)
                                    <span class="text-green-600">Included</span>
                                @else
                                    {{ $course->is_free ? 'Free' : '₦' . number_format($course->price) }}
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                    {{ $course->category->name }}
                                </span>
                                <div class="flex items-center text-yellow-400 text-sm">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="ml-1 text-gray-600">{{ $course->rating }} ({{ $course->total_reviews }})</span>
                                </div>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('courses.show', $course) }}" class="hover:text-blue-600 transition">
                                    {{ $course->title }}
                                </a>
                            </h3>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-1">
                                {{ $course->description }}
                            </p>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden mr-2">
                                        @if($course->instructor_image)
                                            <img src="{{ asset('storage/' . $course->instructor_image) }}" alt="{{ $course->instructor_name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500 text-xs font-bold">
                                                {{ substr($course->instructor_name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-700 font-medium">{{ $course->instructor_name }}</span>
                                </div>
                                <div class="text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $course->duration_hours }}h
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No courses found</h3>
                        <p class="text-gray-500 mt-1">Try adjusting your filters or check back later.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
