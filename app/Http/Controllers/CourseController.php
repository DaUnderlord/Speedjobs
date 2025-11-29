<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Course::published()->with('category');

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $courses = $query->latest()->paginate(12);
        $categories = CourseCategory::orderBy('order')->get();

        return view('courses.index', compact('courses', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        if (!$course->is_published && !auth()->user()?->is_admin) {
            abort(404);
        }

        $course->load(['category', 'lessons' => function ($query) {
            $query->orderBy('order');
        }]);

        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = $course->isEnrolledBy(auth()->id());
        }

        return view('courses.show', compact('course', 'isEnrolled'));
    }
}
