<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status'); // upcoming, past, all
        
        $query = Event::orderBy('start_date', 'desc');
        
        if ($status === 'upcoming') {
            $query->upcoming();
        } elseif ($status === 'past') {
            $query->past();
        }
        
        $events = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'max_attendees' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $event = Event::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully',
            'data' => $event
        ], 201);
    }

    public function show(Event $event): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    public function update(Request $request, Event $event): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'max_attendees' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($event->image_url) {
                $oldImagePath = str_replace('/storage/', '', $event->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $event->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'data' => $event
        ]);
    }

    public function destroy(Event $event): JsonResponse
    {
        // Delete image if exists
        if ($event->image_url) {
            $imagePath = str_replace('/storage/', '', $event->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }

    public function toggleFeatured(Event $event): JsonResponse
    {
        $event->update(['is_featured' => !$event->is_featured]);

        $message = $event->is_featured ? 'Event marked as featured' : 'Event removed from featured';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $event
        ]);
    }

    public function toggleActive(Event $event): JsonResponse
    {
        $event->update(['is_active' => !$event->is_active]);

        $message = $event->is_active ? 'Event activated' : 'Event deactivated';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $event
        ]);
    }
}
