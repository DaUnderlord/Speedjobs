<x-app-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Counselor Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center mb-8">
                        <div class="w-32 h-32 rounded-full bg-gray-200 overflow-hidden mr-6 border-4 border-white shadow-lg">
                            @if($counselor->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $counselor->user->profile_photo_path) }}" alt="{{ $counselor->user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500 text-3xl font-bold">
                                    {{ substr($counselor->user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $counselor->user->name }}</h1>
                            <p class="text-xl text-blue-600 font-medium mb-2">{{ $counselor->specialization }}</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-5 h-5 mr-1 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-bold text-gray-900 mr-1">{{ $counselor->rating }}</span>
                                <span class="mr-4">({{ rand(10, 50) }} reviews)</span>
                                <span class="text-gray-300">|</span>
                                <span class="ml-4">{{ $counselor->experience_years }} Years Experience</span>
                            </div>
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-600 mb-12">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">About Me</h3>
                        <p>{{ $counselor->bio }}</p>
                        
                        @if($counselor->certifications)
                            <h3 class="text-lg font-bold text-gray-900 mt-8 mb-4">Certifications</h3>
                            <ul class="list-disc pl-5">
                                @foreach(json_decode($counselor->certifications) ?? [] as $cert)
                                    <li>{{ $cert }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Booking Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden p-6">
                            <div class="text-center mb-6">
                                <span class="text-sm text-gray-500 uppercase tracking-wide">Session Rate</span>
                                <div class="text-4xl font-bold text-gray-900 mt-1">₦{{ number_format($counselor->hourly_rate) }}<span class="text-base font-normal text-gray-500">/hr</span></div>
                            </div>

                            <form action="{{ route('counselors.book', $counselor) }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Session Type</label>
                                    <select name="session_type" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="virtual">Virtual Meeting (Zoom/Google Meet)</option>
                                        <option value="in-person">In-Person (Office)</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                    <input type="date" name="session_date" min="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                </div>

                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                                    <select name="session_time" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select a time</option>
                                        @foreach(['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'] as $time)
                                            <option value="{{ $time }}">{{ $time }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                                    <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Briefly describe what you'd like to discuss..."></textarea>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-md">
                                    Book Session
                                </button>
                                
                                <p class="text-xs text-center text-gray-500 mt-4">
                                    Secure payment via Paystack. 100% Satisfaction Guarantee.
                                </p>
                            </form>
                        </div>

                        <!-- Availability Info -->
                        <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Typical Availability
                            </h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                @forelse($counselor->availability as $slot)
                                    <li class="flex justify-between">
                                        <span>{{ ucfirst($slot->day_of_week) }}</span>
                                        <span>{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</span>
                                    </li>
                                @empty
                                    <li>Mon - Fri: 9:00 AM - 5:00 PM</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
