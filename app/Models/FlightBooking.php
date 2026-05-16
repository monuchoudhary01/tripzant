<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBooking extends Model
{
    protected $fillable = [
        'booking_id', 'pnr', 'airline_pnr', 'origin', 'destination', 
        'departure_at', 'arrival_at', 'airline_code', 'flight_number', 
        'cabin_class', 'itinerary_details', 'fare_details'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
