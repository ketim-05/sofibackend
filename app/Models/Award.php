<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organization',
        'year',
        'category',
        'is_featured',
        'award_image'
    ];

    protected $casts = [
        'year' => 'integer',
        'is_featured' => 'boolean'
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('year', 'desc');
    }
}
