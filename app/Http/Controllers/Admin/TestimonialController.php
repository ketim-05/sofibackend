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
        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    public function store(TestimonialRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set default sort order if not provided
        $data['sort_order'] = $data['sort_order'] ?? 0;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $testimonial = Testimonial::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial created successfully',
            'data' => $testimonial
        ], 201);
    }

    public function show(Testimonial $testimonial): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $testimonial
        ]);
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): JsonResponse
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            if ($testimonial->image_url) {
                $oldImagePath = str_replace('/storage/', '', $testimonial->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $testimonial->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial updated successfully',
            'data' => $testimonial
        ]);
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        if ($testimonial->image_url) {
            $imagePath = str_replace('/storage/', '', $testimonial->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully'
        ]);
    }

    public function toggleFeatured(Testimonial $testimonial): JsonResponse
    {
        $testimonial->update([
            'is_featured' => !$testimonial->is_featured
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial featured status updated',
            'data' => $testimonial
        ]);
    }
}
