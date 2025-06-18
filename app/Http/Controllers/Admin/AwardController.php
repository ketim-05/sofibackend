<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AwardController extends Controller
{
    public function index(): JsonResponse
    {
        $awards = Award::orderBy('year', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $awards->items(), // Return only the items (array of awards)
            'meta' => [                 // Include pagination info in 'meta' if needed
                'current_page' => $awards->currentPage(),
                'last_page' => $awards->lastPage(),
                'per_page' => $awards->perPage(),
                'total' => $awards->total(),
            ]
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'category' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'award_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('award_image')) {
            $imagePath = $request->file('award_image')->store('awards', 'public');
            $data['award_image'] = $imagePath;
        }

        $award = Award::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Award created successfully',
            'data' => $award
        ], 201);
    }

    public function show(Award $award): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $award
        ]);
    }

    public function update(Request $request, Award $award): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'category' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'award_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('award_image')) {
            if ($award->award_image) {
                Storage::disk('public')->delete($award->award_image);
            }
            
            $imagePath = $request->file('award_image')->store('awards', 'public');
            $data['award_image'] = $imagePath;
        }

        $award->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Award updated successfully',
            'data' => $award
        ]);
    }

    public function destroy(Award $award): JsonResponse
    {
        if ($award->award_image) {
            Storage::disk('public')->delete($award->award_image);
        }

        $award->delete();

        return response()->json([
            'success' => true,
            'message' => 'Award deleted successfully'
        ]);
    }
}
