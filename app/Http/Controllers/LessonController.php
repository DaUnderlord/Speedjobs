<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show(Course $course, CourseLesson $lesson)
    {
        // Check if user has access
        if (!$this->userHasAccess($course, $lesson)) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You need to enroll in this course to view this lesson.');
        }

        // Load course with all lessons for navigation
        $course->load(['lessons' => function ($query) {
            $query->orderBy('order');
        }]);

        // Get previous and next lessons
        $previousLesson = $course->lessons->where('order', '<', $lesson->order)->sortByDesc('order')->first();
        $nextLesson = $course->lessons->where('order', '>', $lesson->order)->sortBy('order')->first();

        // Mark as completed if not already
        if (Auth::check()) {
            LessonProgress::firstOrCreate([
                'user_id' => Auth::id(),
                'course_lesson_id' => $lesson->id,
            ], [
                'is_completed' => true,
                'completed_at' => now(),
            ]);
        }

        return view('courses.learn', compact('course', 'lesson', 'previousLesson', 'nextLesson'));
    }

    protected function userHasAccess(Course $course, CourseLesson $lesson)
    {
        // Admin always has access
        if (Auth::user()?->is_admin) {
            return true;
        }

        // Preview lessons are accessible to everyone
        if ($lesson->is_preview) {
            return true;
        }

        // Check enrollment
        return Auth::check() && $course->isEnrolledBy(Auth::id());
    }
}
