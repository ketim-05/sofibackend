<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Project;
use App\Models\SiteAnalytics;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'blogs' => [
                'total' => Blog::count(),
                'published' => Blog::published()->count(),
                'drafts' => Blog::where('is_published', false)->count()
            ],
            'comments' => [
                'total' => Comment::count(),
                'pending' => Comment::where('is_approved', false)->count(),
                'approved' => Comment::where('is_approved', true)->count()
            ],
            'messages' => [
                'total' => ContactMessage::count(),
                'unread' => ContactMessage::unread()->count(),
                'this_month' => ContactMessage::whereMonth('created_at', Carbon::now()->month)->count()
            ],
            'events' => [
                'total' => Event::count(),
                'upcoming' => Event::upcoming()->count(),
                'this_month' => Event::whereMonth('start_date', Carbon::now()->month)->count()
            ],
            'projects' => [
                'total' => Project::count(),
                'featured' => Project::featured()->count()
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get recent activity
     */
    public function recentActivity(): JsonResponse
    {
        $activities = collect();

        // Recent blogs
        $recentBlogs = Blog::latest()->take(3)->get();
        foreach ($recentBlogs as $blog) {
            $activities->push([
                'type' => 'blog',
                'title' => "New blog post: {$blog->title}",
                'time' => $blog->created_at->diffForHumans(),
                'icon' => '📝'
            ]);
        }

        // Recent comments
        $recentComments = Comment::latest()->take(3)->get();
        foreach ($recentComments as $comment) {
            $activities->push([
                'type' => 'comment',
                'title' => "New comment from {$comment->full_name}",
                'time' => $comment->created_at->diffForHumans(),
                'icon' => '💬'
            ]);
        }

        // Recent messages
        $recentMessages = ContactMessage::latest()->take(3)->get();
        foreach ($recentMessages as $message) {
            $activities->push([
                'type' => 'message',
                'title' => "New message from {$message->name}",
                'time' => $message->created_at->diffForHumans(),
                'icon' => '✉️'
            ]);
        }

        // Sort by time and take latest 10
        $activities = $activities->sortByDesc('time')->take(10)->values();

        return response()->json([
            'success' => true,
            'data' => $activities
        ]);
    }

    /**
     * Get analytics data
     */
    public function analytics(): JsonResponse
    {
        $today = SiteAnalytics::where('date', Carbon::today())->first();
        $thisWeek = SiteAnalytics::whereBetween('date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->get();
        
        $thisMonth = SiteAnalytics::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'today' => [
                    'page_views' => $today->page_views ?? 0,
                    'unique_visitors' => $today->unique_visitors ?? 0,
                    'blog_views' => $today->blog_views ?? 0,
                    'contact_submissions' => $today->contact_submissions ?? 0
                ],
                'this_week' => [
                    'page_views' => $thisWeek->sum('page_views'),
                    'unique_visitors' => $thisWeek->sum('unique_visitors'),
                    'blog_views' => $thisWeek->sum('blog_views'),
                    'contact_submissions' => $thisWeek->sum('contact_submissions')
                ],
                'this_month' => [
                    'page_views' => $thisMonth->sum('page_views'),
                    'unique_visitors' => $thisMonth->sum('unique_visitors'),
                    'blog_views' => $thisMonth->sum('blog_views'),
                    'contact_submissions' => $thisMonth->sum('contact_submissions')
                ]
            ]
        ]);
    }
}
