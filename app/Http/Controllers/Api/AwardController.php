<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AwardController extends Controller
{
    /**
     * Display a listing of awards
     */
    public function index(): JsonResponse
    {
        try {
            $awards = Award::orderBy('year', 'desc')->get()->map(function ($award) {
                return [
                    'id' => $award->id,
                    'title' => $award->title,
                    'organization' => $award->organization,
                    'year' => $award->year,
                    'category' => $award->category,
                    'is_featured' => $award->is_featured,
                    'award_image' => $award->award_image ? Storage::url($award->award_image) : null
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $awards
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch awards',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified award
     */
    public function show(Award $award): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $award->id,
                    'title' => $award->title,
                    'organization' => $award->organization,
                    'year' => $award->year,
                    'category' => $award->category,
                    'is_featured' => $award->is_featured,
                    'award_image' => $award->award_image ? Storage::url($award->award_image) : null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch award',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
