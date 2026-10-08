<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/ServicesIndex', [
            'services' => Service::orderBy('sort_order')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'highlights' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $highlightsArray = $request->filled('highlights') 
            ? array_map('trim', explode(',', $request->highlights)) 
            : [];

        $service = new Service();
        $service->title = $validated['title'];
        $service->tagline = $validated['tagline'];
        $service->description = $validated['description'];
        $service->icon = $validated['icon'];
        $service->highlights = $highlightsArray;
        $service->is_active = $request->boolean('is_active', true);
        $service->sort_order = $request->input('sort_order', 0);
        $service->save();

        return back()->with('success', 'Service created successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'highlights' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $highlightsArray = $request->filled('highlights') 
            ? array_map('trim', explode(',', $request->highlights)) 
            : [];

        $service->title = $validated['title'];
        $service->tagline = $validated['tagline'];
        $service->description = $validated['description'];
        $service->icon = $validated['icon'];
        $service->highlights = $highlightsArray;
        $service->is_active = $request->boolean('is_active', true);
        $service->sort_order = $request->input('sort_order', 0);
        $service->save();

        return back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if (!auth()->user()->hasPermission('delete_services')) {
            return back()->with('error', 'You do not have permission to delete services.');
        }

        $service->delete();
        return back()->with('success', 'Service deleted successfully.');
    }
}
