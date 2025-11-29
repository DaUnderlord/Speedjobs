<x-app-layout>
    <div class="flex h-[calc(100vh-65px)] overflow-hidden bg-white">
        <!-- Sidebar -->
        <div class="w-80 flex-shrink-0 border-r border-gray-200 overflow-y-auto bg-gray-50">
            <div class="p-4 border-b border-gray-200 bg-white sticky top-0 z-10">
                <h2 class="font-bold text-gray-900 truncate" title="{{ $course->title }}">{{ $course->title }}</h2>
                <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $course->enrollments->first()->progress_percentage ?? 0 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ $course->enrollments->first()->progress_percentage ?? 0 }}% Complete</p>
            </div>

            <div class="py-2">
                @foreach($course->lessons as $l)
                    <a href="{{ route('courses.learn', ['course' => $course, 'lesson' => $l]) }}" class="block px-4 py-3 hover:bg-gray-100 transition {{ $lesson->id === $l->id ? 'bg-blue-50 border-l-4 border-blue-600' : 'border-l-4 border-transparent' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-0.5 mr-3">
                                @if($l->isCompletedBy(auth()->id()))
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                @else
                                    <div class="w-5 h-5 rounded-full border-2 border-gray-300"></div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium {{ $lesson->id === $l->id ? 'text-blue-700' : 'text-gray-700' }}">
                                    {{ $l->title }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $l->duration_minutes }} min</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto bg-white">
            <div class="max-w-4xl mx-auto px-8 py-12">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $lesson->title }}</h1>
                </div>

                <!-- Video Player -->
                @if($lesson->video_url)
                    <div class="aspect-w-16 aspect-h-9 bg-black rounded-xl overflow-hidden shadow-lg mb-8">
                        <iframe src="{{ $lesson->video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                    </div>
                @endif

                <!-- Content -->
                <div class="prose max-w-none text-gray-700 mb-12">
                    {!! $lesson->content !!}
                </div>

                <!-- Navigation -->
                <div class="flex items-center justify-between border-t border-gray-200 pt-8">
                    @if($previousLesson)
                        <a href="{{ route('courses.learn', ['course' => $course, 'lesson' => $previousLesson]) }}" class="flex items-center text-gray-600 hover:text-gray-900 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Previous Lesson
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if($nextLesson)
                        <a href="{{ route('courses.learn', ['course' => $course, 'lesson' => $nextLesson]) }}" class="flex items-center text-white bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-full font-medium shadow-sm transition">
                            Next Lesson
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('courses.show', $course) }}" class="flex items-center text-white bg-green-600 hover:bg-green-700 px-6 py-3 rounded-full font-medium shadow-sm transition">
                            Complete Course
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
