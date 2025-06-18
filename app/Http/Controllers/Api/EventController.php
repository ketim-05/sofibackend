<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * Display a listing of events
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status', 'upcoming');
        
        $query = Event::where('is_active', true)
            ->orderBy('start_date', 'desc');
            
        if ($status === 'upcoming') {
            $query->upcoming();
        } elseif ($status === 'past') {
            $query->past();
        }
        
        $events = $query->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $events->items()
        ]);
    }

    /**
     * Display the specified event
     */
    public function show($id): JsonResponse
    {
        $event = Event::find($id);
        
        if (!$event || !$event->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'poster_image' => $event->poster_image,
                'start_date' => $event->formatted_start_date,
                'end_date' => $event->formatted_end_date,
                'door_time' => $event->door_time ? $event->door_time->format('g:i A') : null,
                'location' => $event->location,
                'price' => $event->formatted_price,
                'phone_number' => $event->phone_number,
                'status' => $event->status,
                'is_featured' => $event->is_featured
            ]
        ]);
    }

    /**
     * Get upcoming events
     */
    public function upcoming(): JsonResponse
    {
        $events = Event::where('is_active', true)
            ->upcoming()
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'poster_image' => $event->poster_image,
                    'start_date' => $event->formatted_start_date,
                    'location' => $event->location,
                    'price' => $event->formatted_price
                ];
            });
            
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }
}
