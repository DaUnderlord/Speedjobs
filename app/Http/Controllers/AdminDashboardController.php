<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\Banner;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => Job::count(),
            'active_banners' => Banner::where('is_active', true)->count(),
            'total_courses' => \App\Models\Course::count(),
            'total_enrollments' => \App\Models\CourseEnrollment::count(),
            'total_counselors' => \App\Models\Counselor::count(),
            'pending_requests' => \App\Models\CounselingRequest::where('status', 'pending')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_jobs' => Job::latest()->take(5)->get(),
            'recent_requests' => \App\Models\CounselingRequest::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
