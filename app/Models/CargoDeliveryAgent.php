<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoDeliveryAgent extends Model
{
    use HasFactory;

    protected $table = 'cargo_delivery_agents';

    protected $fillable = [
        'user_id', 'vehicle_type', 'license_number', 'current_location', 'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
