<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Http\Requests\TestimonialRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->paginate(15);
        
        // Transform the data to match frontend expectations
        $transformedTestimonials = $testimonials->map(function ($testimonial) {
            return [
                'id' => $testimonial->id,
                'client_name' => $testimonial->name,
                'client_image' => $testimonial->image_url,
                'testimonial' => $testimonial->message,
                'client_position' => $testimonial->position,
                'client_company' => $testimonial->company,
                'rating' => $testimonial->rating,
                'is_featured' => $testimonial->is_featured,
                'is_active' => $testimonial->is_active,
                'sort_order' => $testimonial->sort_order,
                'created_at' => $testimonial->created_at,
                'updated_at' => $testimonial->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $transformedTestimonials
        ]);
    }

    public function store(TestimonialRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            
            // Set default sort order if not provided
            $data['sort_order'] = $data['sort_order'] ?? 0;
            
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('testimonials', 'public');
                $data['image_url'] = $imagePath;
            }

            $testimonial = Testimonial::create($data);

            // Transform the response to match frontend expectations
            $transformedTestimonial = [
                'id' => $testimonial->id,
                'client_name' => $testimonial->name,
                'client_image' => $testimonial->image_url,
                'testimonial' => $testimonial->message,
                'client_position' => $testimonial->position,
                'client_company' => $testimonial->company,
                'rating' => $testimonial->rating,
                'is_featured' => $testimonial->is_featured,
                'is_active' => $testimonial->is_active,
                'sort_order' => $testimonial->sort_order,
                'created_at' => $testimonial->created_at,
                'updated_at' => $testimonial->updated_at,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Testimonial created successfully',
                'data' => $transformedTestimonial
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save testimonial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Testimonial $testimonial): JsonResponse
    {
        // Transform the response to match frontend expectations
        $transformedTestimonial = [
            'id' => $testimonial->id,
            'client_name' => $testimonial->name,
            'client_image' => $testimonial->image_url,
            'testimonial' => $testimonial->message,
            'client_position' => $testimonial->position,
            'client_company' => $testimonial->company,
            'rating' => $testimonial->rating,
            'is_featured' => $testimonial->is_featured,
            'is_active' => $testimonial->is_active,
            'sort_order' => $testimonial->sort_order,
            'created_at' => $testimonial->created_at,
            'updated_at' => $testimonial->updated_at,
        ];

        return response()->json([
            'success' => true,
            'data' => $transformedTestimonial
        ]);
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): JsonResponse
    {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('image')) {
                if ($testimonial->image_url) {
                    Storage::disk('public')->delete($testimonial->image_url);
                }
                
                $imagePath = $request->file('image')->store('testimonials', 'public');
                $data['image_url'] = $imagePath;
            }

            $testimonial->update($data);

            // Transform the response to match frontend expectations
            $transformedTestimonial = [
                'id' => $testimonial->id,
                'client_name' => $testimonial->name,
                'client_image' => $testimonial->image_url,
                'testimonial' => $testimonial->message,
                'client_position' => $testimonial->position,
                'client_company' => $testimonial->company,
                'rating' => $testimonial->rating,
                'is_featured' => $testimonial->is_featured,
                'is_active' => $testimonial->is_active,
                'sort_order' => $testimonial->sort_order,
                'created_at' => $testimonial->created_at,
                'updated_at' => $testimonial->updated_at,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Testimonial updated successfully',
                'data' => $transformedTestimonial
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update testimonial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        try {
            if ($testimonial->image_url) {
                Storage::disk('public')->delete($testimonial->image_url);
            }

            $testimonial->delete();

            return response()->json([
                'success' => true,
                'message' => 'Testimonial deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete testimonial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function toggleFeatured(Testimonial $testimonial): JsonResponse
    {
        try {
            $testimonial->update([
                'is_featured' => !$testimonial->is_featured
            ]);

            // Transform the response to match frontend expectations
            $transformedTestimonial = [
                'id' => $testimonial->id,
                'client_name' => $testimonial->name,
                'client_image' => $testimonial->image_url,
                'testimonial' => $testimonial->message,
                'client_position' => $testimonial->position,
                'client_company' => $testimonial->company,
                'rating' => $testimonial->rating,
                'is_featured' => $testimonial->is_featured,
                'is_active' => $testimonial->is_active,
                'sort_order' => $testimonial->sort_order,
                'created_at' => $testimonial->created_at,
                'updated_at' => $testimonial->updated_at,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Testimonial featured status updated',
                'data' => $transformedTestimonial
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
