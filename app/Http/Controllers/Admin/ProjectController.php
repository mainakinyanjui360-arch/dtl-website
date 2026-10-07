<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/ProjectsIndex', [
            'projects' => Project::orderBy('sort_order')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $project = new Project();
        $project->title = $validated['title'];
        $project->client = $validated['client'] ?? null;
        $project->description = $validated['description'];
        $project->category = $validated['category'] ?? null;
        $project->completion_date = $validated['completion_date'] ?? null;
        $project->is_active = $request->boolean('is_active', true);
        $project->sort_order = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $project->image = '/storage/' . $path;
        }

        $project->save();

        return back()->with('success', 'Project created successfully.');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $project->title = $validated['title'];
        $project->client = $validated['client'] ?? null;
        $project->description = $validated['description'];
        $project->category = $validated['category'] ?? null;
        $project->completion_date = $validated['completion_date'] ?? null;
        $project->is_active = $request->boolean('is_active', true);
        $project->sort_order = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $project->image));
            }
            $path = $request->file('image')->store('projects', 'public');
            $project->image = '/storage/' . $path;
        }

        $project->save();

        return back()->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $project->image));
        }
        $project->delete();
        return back()->with('success', 'Project deleted successfully.');
    }
}
