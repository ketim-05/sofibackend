<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'poster_image',
        'start_date',
        'end_date',
        'door_time',
        'location',
        'venue',
        'price',
        'max_attendees',
        'phone_number',
        'status',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'door_time' => 'datetime:H:i',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', Carbon::now())
                    ->orWhere('status', 'upcoming');
    }

    public function scopePast($query)
    {
        return $query->where('start_date', '<', Carbon::now())
                    ->orWhere('status', 'completed');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price ? number_format($this->price, 0) . ' Br' : 'Free';
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date->format('F j, Y g:i A');
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date->format('F j, Y g:i A');
    }
}
