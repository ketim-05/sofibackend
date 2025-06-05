<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        $clients = Client::orderBy('sort_order', 'asc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $clients
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('clients', 'public');
            $data['logo_url'] = Storage::url($logoPath);
        }

        // Set sort order if not provided
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = Client::max('sort_order') + 1;
        }

        $client = Client::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Client created successfully',
            'data' => $client
        ], 201);
    }

    public function show(Client $client): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $client
        ]);
    }

    public function update(Request $request, Client $client): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('logo')) {
            if ($client->logo_url) {
                $oldLogoPath = str_replace('/storage/', '', $client->logo_url);
                Storage::disk('public')->delete($oldLogoPath);
            }
            
            $logoPath = $request->file('logo')->store('clients', 'public');
            $data['logo_url'] = Storage::url($logoPath);
        }

        $client->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Client updated successfully',
            'data' => $client
        ]);
    }

    public function destroy(Client $client): JsonResponse
    {
        if ($client->logo_url) {
            $logoPath = str_replace('/storage/', '', $client->logo_url);
            Storage::disk('public')->delete($logoPath);
        }

        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client deleted successfully'
        ]);
    }
}
