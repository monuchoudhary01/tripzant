<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'location', 'price', 'duration', 
        'images', 'itinerary', 'inclusions', 'exclusions', 'is_active'
    ];

    protected $casts = [
        'images' => 'array',
        'itinerary' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'is_active' => 'boolean',
    ];
}
