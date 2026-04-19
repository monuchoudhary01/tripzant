<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoProvider extends Model
{
    use HasFactory;

    protected $table = 'cargo_providers';

    protected $fillable = [
        'name', 'logo_url', 'api_endpoint', 'api_key',
        'base_rate', 'per_kg_rate', 'commission_percentage',
        'rating', 'supported_countries', 'is_active'
    ];

    protected $casts = [
        'supported_countries' => 'array',
        'is_active' => 'boolean',
    ];

    public function bookings() {
        return $this->hasMany(CargoBooking::class, 'provider_id');
    }
}
