<x-app-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Course Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ $course->category->name }}
                        </span>
                        <span class="text-gray-300">|</span>
                        <span class="text-sm text-gray-500">{{ ucfirst($course->level) }} Level</span>
                        <span class="text-gray-300">|</span>
                        <div class="flex items-center text-yellow-400 text-sm">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="ml-1 text-gray-600">{{ $course->rating }} ({{ $course->total_reviews }} reviews)</span>
                        </div>
                    </div>

                    <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $course->title }}</h1>
                    <p class="text-lg text-gray-600 mb-8">{{ $course->description }}</p>

                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden mr-4">
                            @if($course->instructor_image)
                                <img src="{{ asset('storage/' . $course->instructor_image) }}" alt="{{ $course->instructor_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500 text-sm font-bold">
                                    {{ substr($course->instructor_name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">Created by {{ $course->instructor_name }}</div>
                            <div class="text-sm text-gray-500">Last updated {{ $course->updated_at->format('M Y') }}</div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div x-data="{ activeTab: 'overview' }" class="border-b border-gray-200 mb-8">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="activeTab = 'overview'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'overview' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Overview
                            </button>
                            <button @click="activeTab = 'curriculum'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'curriculum', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'curriculum' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Curriculum
                            </button>
                            <button @click="activeTab = 'instructor'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'instructor', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'instructor' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Instructor
                            </button>
                        </nav>

                        <div class="py-8">
                            <!-- Overview Tab -->
                            <div x-show="activeTab === 'overview'" class="prose max-w-none text-gray-600">
                                {!! $course->long_description !!}
                            </div>

                            <!-- Curriculum Tab -->
                            <div x-show="activeTab === 'curriculum'" style="display: none;">
                                <div class="space-y-4">
                                    @foreach($course->lessons as $lesson)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 text-sm font-medium mr-3">
                                                    {{ $loop->iteration }}
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $lesson->title }}</h4>
                                                    <span class="text-xs text-gray-500">{{ $lesson->duration_minutes }} mins</span>
                                                </div>
                                            </div>
                                            @if($lesson->is_preview || $isEnrolled)
                                                <a href="{{ route('courses.learn', ['course' => $course, 'lesson' => $lesson]) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                                    {{ $isEnrolled ? 'Start' : 'Preview' }}
                                                </a>
                                            @else
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Instructor Tab -->
                            <div x-show="activeTab === 'instructor'" style="display: none;">
                                <div class="flex items-start">
                                    <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden mr-6 flex-shrink-0">
                                        @if($course->instructor_image)
                                            <img src="{{ asset('storage/' . $course->instructor_image) }}" alt="{{ $course->instructor_name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500 text-xl font-bold">
                                                {{ substr($course->instructor_name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $course->instructor_name }}</h3>
                                        <p class="text-gray-600">{{ $course->instructor_bio }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <!-- Preview Video/Image -->
                            <div class="aspect-w-16 aspect-h-9 bg-gray-900 relative group cursor-pointer">
                                @if($course->thumbnail_image)
                                    <img src="{{ asset('storage/' . $course->thumbnail_image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-75 transition">
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition transform">
                                        <svg class="w-6 h-6 text-blue-600 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="text-3xl font-bold text-gray-900 mb-4">
                                    @if(auth()->user() && auth()->user()->is_paid)
                                        <span class="text-green-600">Included with Membership</span>
                                    @else
                                        {{ $course->is_free ? 'Free' : '₦' . number_format($course->price) }}
                                    @endif
                                </div>

                                @if($isEnrolled)
                                    <a href="{{ route('courses.learn', ['course' => $course]) }}" class="block w-full bg-green-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-green-700 transition mb-4">
                                        Continue Learning
                                    </a>
                                @elseif(auth()->user() && auth()->user()->is_paid)
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $course->duration_hours }} hours on-demand video
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        {{ $course->lessons->count() }} lessons
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        Access on mobile and TV
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Certificate of completion
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
