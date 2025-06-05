<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NewsletterSubscriptionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = NewsletterSubscription::query();

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Search by email or name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->orderBy('subscribed_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $subscriptions
        ]);
    }

    public function show(NewsletterSubscription $subscription): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $subscription
        ]);
    }

    public function updateStatus(Request $request, NewsletterSubscription $subscription): JsonResponse
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        $subscription->update([
            'is_active' => $request->is_active
        ]);

        $message = $request->is_active ? 'Subscription activated' : 'Subscription deactivated';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $subscription
        ]);
    }

    public function destroy(NewsletterSubscription $subscription): JsonResponse
    {
        $subscription->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subscription deleted successfully'
        ]);
    }

    public function stats(): JsonResponse
    {
        $stats = [
            'total' => NewsletterSubscription::count(),
            'active' => NewsletterSubscription::where('is_active', true)->count(),
            'inactive' => NewsletterSubscription::where('is_active', false)->count(),
            'this_month' => NewsletterSubscription::whereMonth('subscribed_at', now()->month)->count(),
            'this_week' => NewsletterSubscription::whereBetween('subscribed_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    public function export(): JsonResponse
    {
        $subscriptions = NewsletterSubscription::where('is_active', true)
            ->select('email', 'name', 'subscribed_at')
            ->orderBy('subscribed_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subscriptions,
            'message' => 'Subscriptions exported successfully'
        ]);
    }
}
