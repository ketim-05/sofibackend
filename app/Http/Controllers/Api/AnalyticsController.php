<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteAnalytics;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AnalyticsController extends Controller
{
    /**
     * Record a page view
     */
    public function recordPageView(Request $request): JsonResponse
    {
        $page = $request->input('page');
        
        try {
            SiteAnalytics::recordPageView($page);
            
            return response()->json([
                'success' => true,
                'message' => 'Page view recorded'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to record page view'
            ], 500);
        }
    }

    /**
     * Get basic analytics data (for admin dashboard)
     */
    public function dashboard(): JsonResponse
    {
        $today = SiteAnalytics::where('date', now()->toDateString())->first();
        $thisMonth = SiteAnalytics::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('page_views');
            
        return response()->json([
            'success' => true,
            'data' => [
                'today' => [
                    'page_views' => $today->page_views ?? 0,
                    'unique_visitors' => $today->unique_visitors ?? 0,
                    'blog_views' => $today->blog_views ?? 0,
                    'contact_submissions' => $today->contact_submissions ?? 0
                ],
                'this_month' => [
                    'total_page_views' => $thisMonth
                ]
            ]
        ]);
    }
}
