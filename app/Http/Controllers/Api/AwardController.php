<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AwardController extends Controller
{
    /**
     * Display a listing of awards
     */
    public function index(): JsonResponse
    {
        $awards = Award::ordered()->get()->map(function ($award) {
            return [
                'id' => $award->id,
                'title' => $award->title,
                'organization' => $award->organization,
                'year' => $award->year,
                'image_url' => $award->image_url,
                'description' => $award->description
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $awards
        ]);
    }

    /**
     * Display the specified award
     */
    public function show(Award $award): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $award->id,
                'title' => $award->title,
                'organization' => $award->organization,
                'year' => $award->year,
                'image_url' => $award->image_url,
                'description' => $award->description
            ]
        ]);
    }
}
