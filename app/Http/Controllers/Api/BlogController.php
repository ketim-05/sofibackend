<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 16);
            
            // Filter by published blogs using is_published column
            $blogs = Blog::where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->paginate($perPage);

            return response()->json($blogs);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch blogs',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $blog = Blog::where('is_published', true)
                ->findOrFail($id);
            return response()->json($blog);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Blog not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'image_url' => 'nullable|string',
            'author' => 'required|string',
            'category' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $blog = Blog::create($validated);
        return response()->json($blog, 201);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'excerpt' => 'nullable|string',
            'image_url' => 'nullable|string',
            'author' => 'string',
            'category' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $blog->update($validated);
        return response()->json($blog);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return response()->json(['message' => 'Blog deleted successfully']);
    }

    public function featured()
    {
        try {
            // Get first 6 published blogs as "featured"
            $blogs = Blog::where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->limit(6)
                ->get();

            return response()->json($blogs);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch featured blogs',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}
