<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    /**
     * Test API endpoint
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Sofi Studio API is working!',
            'data' => [
                'version' => '1.0.0',
                'timestamp' => now()->toISOString(),
                'endpoints' => [
                    'blogs' => '/api/v1/blogs',
                    'projects' => '/api/v1/projects',
                    'services' => '/api/v1/services',
                    'events' => '/api/v1/events',
                    'contact' => '/api/v1/contact',
                    'testimonials' => '/api/v1/testimonials',
                    'clients' => '/api/v1/clients',
                    'awards' => '/api/v1/awards'
                ]
            ]
        ]);
    }
}
