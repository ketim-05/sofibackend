<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_analytics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('page_views')->default(0);
            $table->integer('unique_visitors')->default(0);
            $table->integer('blog_views')->default(0);
            $table->integer('contact_submissions')->default(0);
            $table->decimal('bounce_rate', 3, 2)->default(0); // Add this column
            $table->integer('avg_session_duration')->default(0); // Add this column (in seconds)
            $table->json('top_pages')->nullable(); // Add this column
            $table->json('traffic_sources')->nullable(); // Add this column
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_analytics');
    }
};
