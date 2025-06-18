<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of active clients
     */
    public function index(): JsonResponse
    {
        $clients = Client::active()->get()->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->name,
                'logo_url' => $client->logo_url,
                'website_url' => $client->website_url,
                'description' => $client->description
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $clients
        ]);
    }

    /**
     * Display the specified client
     */
    public function show($id): JsonResponse
    {
        try {
            $client = Client::find($id);
            
            if (!$client || !$client->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client not found'
                ], 404);
            }
            
            // Ensure logo_url is properly formatted
            $logoUrl = $client->logo_url;
            if ($logoUrl && !str_starts_with($logoUrl, 'http')) {
                $logoUrl = asset('storage/' . ltrim($logoUrl, '/'));
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $client->id,
                    'name' => $client->name,
                    'logo_url' => $logoUrl,
                    'website_url' => $client->website_url,
                    'description' => $client->description
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Client show error: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the client'
            ], 500);
        }
    }
}
