<?php

namespace App\Http\Controllers;

use App\Models\CounselingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselingRequestController extends Controller
{
    public function index()
    {
        $requests = Auth::user()->counselingRequests()->latest()->get();
        return view('counseling.index', compact('requests'));
    }

    public function create()
    {
        return view('counseling.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'request_type' => 'required|string',
            'message' => 'required|string|max:1000',
            'preferred_date' => 'nullable|date|after:today',
            'preferred_time' => 'nullable',
        ]);

        Auth::user()->counselingRequests()->create([
            'request_type' => $request->request_type,
            'message' => $request->message,
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'status' => 'pending',
        ]);

        return redirect()->route('counseling.index')->with('success', 'Your counseling request has been submitted successfully. An admin will assign a counselor to you shortly.');
    }
}
