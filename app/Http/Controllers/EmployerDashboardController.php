<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployerDashboardController extends Controller
{
    public function index()
    {
        // Fetch jobs posted by the authenticated user
        $jobs = \App\Models\Job::where('user_id', auth()->id())->latest()->get();
        $applications = []; // Placeholder for now

        return view('employer.dashboard', compact('jobs', 'applications'));
    }
}
