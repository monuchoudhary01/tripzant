<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoTracking extends Model
{
    use HasFactory;

    protected $table = 'cargo_tracking';

    protected $fillable = [
        'booking_id', 'status', 'location_name', 'latitude', 'longitude', 'description'
    ];

    public function booking() {
        return $this->belongsTo(CargoBooking::class, 'booking_id');
    }
}
