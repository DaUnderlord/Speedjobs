<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::latest()->paginate(10);
        return view('admin.resources.index', compact('resources'));
    }

    public function create()
    {
        return view('admin.resources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB max
            'is_active' => 'boolean',
        ]);

        $path = $request->file('file')->store('resources', 'public');

        Resource::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.resources.index')->with('success', 'Resource uploaded successfully.');
    }

    public function destroy(Resource $resource)
    {
        if (Storage::disk('public')->exists($resource->file_path)) {
            Storage::disk('public')->delete($resource->file_path);
        }
        
        $resource->delete();

        return redirect()->route('admin.resources.index')->with('success', 'Resource deleted successfully.');
    }
}
