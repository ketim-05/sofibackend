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
    public function show(Client $client): JsonResponse
    {
        if (!$client->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $client->id,
                'name' => $client->name,
                'logo_url' => $client->logo_url,
                'website_url' => $client->website_url,
                'description' => $client->description
            ]
        ]);
    }
}
