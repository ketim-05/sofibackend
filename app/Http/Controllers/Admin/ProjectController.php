<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'technologies' => 'nullable|array',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:planning,in_progress,completed,on_hold',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'completion_date' => 'nullable|date',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $project = Project::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully',
            'data' => $project
        ], 201);
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $project
        ]);
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'technologies' => 'nullable|array',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:planning,in_progress,completed,on_hold',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'completion_date' => 'nullable|date',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            if ($project->image_url) {
                $oldImagePath = str_replace('/storage/', '', $project->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $imagePath = $request->file('image')->store('projects', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $project->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'data' => $project
        ]);
    }

    public function destroy(Project $project): JsonResponse
    {
        if ($project->image_url) {
            $imagePath = str_replace('/storage/', '', $project->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully'
        ]);
    }
}
