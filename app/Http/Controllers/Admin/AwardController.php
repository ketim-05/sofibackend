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
        $awards = Award::orderBy('award_date', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $awards
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organization' => 'required|string|max:255',
            'award_date' => 'required|date',
            'award_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('award_image')) {
            $imagePath = $request->file('award_image')->store('awards', 'public');
            $data['award_image'] = Storage::url($imagePath);
        }

        // Set sort order if not provided
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = Award::max('sort_order') + 1;
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
            'description' => 'nullable|string',
            'organization' => 'required|string|max:255',
            'award_date' => 'required|date',
            'award_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('award_image')) {
            if ($award->award_image) {
                $oldImagePath = str_replace('/storage/', '', $award->award_image);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $imagePath = $request->file('award_image')->store('awards', 'public');
            $data['award_image'] = Storage::url($imagePath);
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
            $imagePath = str_replace('/storage/', '', $award->award_image);
            Storage::disk('public')->delete($imagePath);
        }

        $award->delete();

        return response()->json([
            'success' => true,
            'message' => 'Award deleted successfully'
        ]);
    }
}
