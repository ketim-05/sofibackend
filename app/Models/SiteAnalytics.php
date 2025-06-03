<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'page_views',
        'unique_visitors',
        'blog_views',
        'contact_submissions',
        'bounce_rate',
        'avg_session_duration',
        'top_pages',
        'traffic_sources'
    ];

    protected $casts = [
        'date' => 'date',
        'bounce_rate' => 'decimal:2',
        'top_pages' => 'array',
        'traffic_sources' => 'array'
    ];
}
