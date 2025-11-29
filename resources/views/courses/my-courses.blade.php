<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Learning</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($enrollments as $enrollment)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100 flex flex-col h-full">
                        <div class="relative h-40 bg-gray-200">
                            @if($enrollment->course->thumbnail_image)
                                <img src="{{ asset('storage/' . $enrollment->course->thumbnail_image) }}" alt="{{ $enrollment->course->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full bg-blue-50 text-blue-200">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('courses.show', $enrollment->course) }}" class="hover:text-blue-600 transition">
                                    {{ $enrollment->course->title }}
                                </a>
                            </h3>

                            <div class="mt-auto pt-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>{{ $enrollment->progress_percentage }}% Complete</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>

                                <a href="{{ route('courses.learn', ['course' => $enrollment->course]) }}" class="block w-full bg-gray-900 text-white text-center py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                                    {{ $enrollment->progress_percentage > 0 ? 'Continue Learning' : 'Start Course' }}
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-4">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">You haven't enrolled in any courses yet</h3>
                        <p class="text-gray-500 mt-1 mb-6">Start your learning journey today.</p>
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Browse Courses
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
