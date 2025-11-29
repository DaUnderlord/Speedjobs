<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-1">Request Details</h1>
                            <p class="text-sm text-gray-500">Submitted on {{ $counselingRequest->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $counselingRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($counselingRequest->status) }}
                        </span>
                    </div>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- User Info -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Applicant Information</h3>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-lg mr-4">
                                    {{ substr($counselingRequest->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $counselingRequest->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $counselingRequest->user->email }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Request Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Specifics</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Topic</dt>
                                <dd class="text-gray-900">{{ $counselingRequest->request_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Preferred Date</dt>
                                <dd class="text-gray-900">{{ $counselingRequest->preferred_date ? $counselingRequest->preferred_date->format('M d, Y') : 'Not specified' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Preferred Time</dt>
                                <dd class="text-gray-900">{{ $counselingRequest->preferred_time ? $counselingRequest->preferred_time->format('g:i A') : 'Not specified' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Message -->
                    <div class="col-span-full">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Message</h3>
                        <div class="bg-gray-50 rounded-xl p-6 text-gray-700 leading-relaxed">
                            {{ $counselingRequest->message }}
                        </div>
                    </div>

                    <!-- Assignment Form -->
                    <div class="col-span-full border-t border-gray-200 pt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Assign Counselor</h3>
                        
                        <form action="{{ route('admin.counseling.assign', $counselingRequest) }}" method="POST" class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Counselor</label>
                                    <select name="counselor_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Choose a counselor...</option>
                                        @foreach($counselors as $counselor)
                                            <option value="{{ $counselor->id }}" {{ $counselingRequest->assigned_counselor_id == $counselor->id ? 'selected' : '' }}>
                                                {{ $counselor->user->name }} ({{ $counselor->specialization }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes (Internal)</label>
                                    <textarea name="admin_notes" rows="1" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Optional notes...">{{ $counselingRequest->admin_notes }}</textarea>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition shadow-sm">
                                    {{ $counselingRequest->assigned_counselor_id ? 'Update Assignment' : 'Assign Counselor' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
