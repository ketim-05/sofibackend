<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    /**
     * Display a listing of active services
     */
    public function index(): JsonResponse
    {
        try {
            $services = Service::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($services);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch services',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified service
     */
    public function show($id): JsonResponse
    {
        try {
            $service = Service::where('is_active', true)
                ->findOrFail($id);
            return response()->json($service);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Service not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
