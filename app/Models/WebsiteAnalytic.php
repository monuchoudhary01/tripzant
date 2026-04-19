<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteAnalytic extends Model
{
    use HasFactory;

    protected $table = 'website_analytics';

    protected $fillable = [
        'domain', 'name', 'monthly_traffic', 'traffic_count',
        'traffic_sources', 'top_countries', 'category', 'status',
        'contact_email', 'contact_phone', 'social_links',
        'total_bookings', 'revenue_generated', 'pitch_sent'
    ];

    protected $casts = [
        'traffic_sources' => 'array',
        'top_countries' => 'array',
        'social_links' => 'array',
        'pitch_sent' => 'boolean',
        'revenue_generated' => 'decimal:2',
    ];
}
