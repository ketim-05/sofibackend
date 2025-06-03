<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteAnalytics;
use Carbon\Carbon;

class SiteAnalyticsSeeder extends Seeder
{
    public function run(): void
    {
        $analytics = [];
        
        // Generate analytics data for the last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            $analytics[] = [
                'date' => $date->format('Y-m-d'),
                'page_views' => rand(100, 500),
                'unique_visitors' => rand(30, 150),
                'blog_views' => rand(20, 100),
                'contact_submissions' => rand(0, 10),
                'bounce_rate' => round(rand(30, 70) / 100, 2), // 0.30 to 0.70
                'avg_session_duration' => rand(120, 600), // 2-10 minutes in seconds
                'top_pages' => json_encode([
                    '/home' => rand(50, 200),
                    '/about' => rand(20, 80),
                    '/services' => rand(15, 60),
                    '/blog' => rand(10, 50),
                    '/contact' => rand(5, 30)
                ]),
                'traffic_sources' => json_encode([
                    'direct' => rand(30, 60),
                    'google' => rand(20, 40),
                    'social_media' => rand(10, 30),
                    'referral' => rand(5, 20)
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        foreach ($analytics as $analyticsData) {
            SiteAnalytics::create($analyticsData);
        }
    }
}
