<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Career Planning Workbook</h1>
                <p class="text-lg text-gray-600">A strategic tool to help you define your career goals and create an actionable plan.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <form action="{{ route('career-planning.store') }}" method="POST" class="p-8">
                    @csrf
                    
                    <!-- Section 1: Self Assessment -->
                    <div class="mb-12">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-200 flex items-center">
                            <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm mr-3">1</span>
                            Self Assessment
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">What are your top 3 professional strengths?</label>
                                <textarea name="strengths" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., Problem solving, Communication, Data analysis..."></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">What are your core values in a workplace?</label>
                                <textarea name="values" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., Work-life balance, Innovation, Social impact..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">What activities energize you the most?</label>
                                <textarea name="interests" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., Mentoring others, Solving complex technical problems..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Goal Setting -->
                    <div class="mb-12">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-200 flex items-center">
                            <span class="bg-purple-100 text-purple-600 w-8 h-8 rounded-full flex items-center justify-center text-sm mr-3">2</span>
                            Goal Setting
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Short-term Career Goal (6-12 months)</label>
                                <input type="text" name="short_term_goal" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" placeholder="e.g., Get promoted to Senior Developer">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Long-term Career Goal (3-5 years)</label>
                                <input type="text" name="long_term_goal" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" placeholder="e.g., Become a CTO of a tech startup">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Gap Analysis -->
                    <div class="mb-12">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-200 flex items-center">
                            <span class="bg-orange-100 text-orange-600 w-8 h-8 rounded-full flex items-center justify-center text-sm mr-3">3</span>
                            Gap Analysis
                        </h2>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">What skills or qualifications do you need to acquire?</label>
                                <textarea name="skills_gap" rows="3" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500" placeholder="e.g., Learn Python, Get PMP certification..."></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">What experiences do you need to gain?</label>
                                <textarea name="experience_gap" rows="3" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500" placeholder="e.g., Lead a team project, Public speaking..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Action Plan -->
                    <div class="mb-12">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-200 flex items-center">
                            <span class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center text-sm mr-3">4</span>
                            Action Plan
                        </h2>
                        
                        <div class="space-y-4">
                            <p class="text-sm text-gray-500 mb-4">List 3 specific actions you will take in the next 30 days.</p>
                            
                            <div class="flex items-center">
                                <span class="text-gray-400 mr-3">1.</span>
                                <input type="text" name="action_1" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" placeholder="Action item 1">
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-400 mr-3">2.</span>
                                <input type="text" name="action_2" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" placeholder="Action item 2">
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-400 mr-3">3.</span>
                                <input type="text" name="action_3" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" placeholder="Action item 3">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                        <button type="button" class="mr-4 text-gray-600 hover:text-gray-900 font-medium">Save Draft</button>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-md">
                            Save Career Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
