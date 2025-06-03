<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'technologies',
        'client_name',
        'project_url',
        'completion_date',
        'is_featured',
        'status'
    ];

    protected $casts = [
        'technologies' => 'array', // This will automatically convert to/from JSON
        'completion_date' => 'date',
        'is_featured' => 'boolean'
    ];
}
