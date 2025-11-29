<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use Illuminate\Http\Request;

class CounselorController extends Controller
{
    public function index(Request $request)
    {
        $query = Counselor::with('user')->available();

        if ($request->has('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        $counselors = $query->latest()->paginate(12);
        
        // Get unique specializations for filter
        $specializations = Counselor::available()->select('specialization')->distinct()->pluck('specialization');

        return view('counselors.index', compact('counselors', 'specializations'));
    }

    public function show(Counselor $counselor)
    {
        $counselor->load(['user', 'availability' => function($q) {
            $q->where('is_active', true)->orderBy('day_of_week')->orderBy('start_time');
        }]);

        return view('counselors.show', compact('counselor'));
    }
}
