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
        'image_url',
        'description',
        'sort_order'
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('year', 'desc');
    }
}
