<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            BlogSeeder::class,
            CommentSeeder::class,
            ProjectSeeder::class,
            ServiceSeeder::class,
            EventSeeder::class,
            TestimonialSeeder::class,
            ClientSeeder::class,
            AwardSeeder::class,
            ContactMessageSeeder::class,
            SiteAnalyticsSeeder::class,
        ]);
    }
}
