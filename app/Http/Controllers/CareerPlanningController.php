<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CareerPlanningController extends Controller
{
    public function index()
    {
        return view('career-planning.index');
    }

    public function store(Request $request)
    {
        // Logic to save workbook progress will go here
        // For now, we can just redirect back with a success message
        return back()->with('success', 'Workbook progress saved!');
    }
}
