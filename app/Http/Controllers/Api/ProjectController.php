<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects
     */
    public function index(Request $request): JsonResponse
    {
        $category = $request->get('category');
        $featured = $request->get('featured');
        
        $query = Project::ordered();
        
        if ($category) {
            $query->byCategory($category);
        }
        
        if ($featured) {
            $query->featured();
        }
        
        $projects = $query->get()->map(function ($project) {
            return [
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'category' => $project->category,
                'client' => $project->client,
                'year' => $project->year,
                'images' => $project->images,
                'video_url' => $project->video_url,
                'audio_url' => $project->audio_url,
                'credits' => $project->credits,
                'is_featured' => $project->is_featured
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    /**
     * Display the specified project
     */
    public function show(Project $project): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'category' => $project->category,
                'client' => $project->client,
                'year' => $project->year,
                'images' => $project->images,
                'video_url' => $project->video_url,
                'audio_url' => $project->audio_url,
                'credits' => $project->credits,
                'is_featured' => $project->is_featured
            ]
        ]);
    }

    /**
     * Get projects by category
     */
    public function byCategory($category): JsonResponse
    {
        $projects = Project::byCategory($category)
            ->ordered()
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'images' => $project->images,
                    'year' => $project->year
                ];
            });
            
        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    /**
     * Get portfolio categories
     */
    public function categories(): JsonResponse
    {
        $categories = Project::select('category')
            ->distinct()
            ->pluck('category');
            
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
