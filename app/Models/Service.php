<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'detailed_description',
        'icon',
        'image_url',
        'price',
        'price_type',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'features' => 'array', // If features is stored as JSON
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope for active services
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor for formatted price
    public function getFormattedPriceAttribute()
    {
        if (!$this->price) return 'Contact for pricing';
        
        return '$' . number_format($this->price, 2) . ' ' . ($this->price_type ?? 'per project');
    }
}
