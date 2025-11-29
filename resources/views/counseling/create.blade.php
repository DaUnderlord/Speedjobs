<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Request Career Counseling</h1>
                    <p class="text-gray-600 mb-8">Tell us about your needs, and we'll match you with the perfect expert counselor.</p>

                    <form action="{{ route('counseling.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">What type of guidance do you need?</label>
                            <select name="request_type" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Select a topic</option>
                                <option value="Career Transition">Career Transition</option>
                                <option value="Interview Coaching">Interview Coaching</option>
                                <option value="Resume Review">Resume Review</option>
                                <option value="Executive Leadership">Executive Leadership</option>
                                <option value="General Guidance">General Guidance</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Describe your situation and goals</label>
                            <textarea name="message" rows="5" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="I'm looking to switch from marketing to tech..." required></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date (Optional)</label>
                                <input type="date" name="preferred_date" min="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Time (Optional)</label>
                                <input type="time" name="preferred_time" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-md">
                            Submit Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
