<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    /**
     * Display a listing of active testimonials
     */
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::active()->get()->map(function ($testimonial) {
            return [
                'id' => $testimonial->id,
                'name' => $testimonial->name,
                'position' => $testimonial->position,
                'company' => $testimonial->company,
                'message' => $testimonial->message,
                'image_url' => $testimonial->image_url,
                'rating' => $testimonial->rating
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    /**
     * Display the specified testimonial
     */
    public function show(Testimonial $testimonial): JsonResponse
    {
        if (!$testimonial->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Testimonial not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $testimonial->id,
                'name' => $testimonial->name,
                'position' => $testimonial->position,
                'company' => $testimonial->company,
                'message' => $testimonial->message,
                'image_url' => $testimonial->image_url,
                'rating' => $testimonial->rating
            ]
        ]);
    }
}
