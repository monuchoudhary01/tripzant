<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    protected $fillable = [
        'booking_id', 'type', 'title', 'first_name', 'last_name', 'dob', 
        'passport_number', 'passport_expiry', 'seat_number', 'meal_preference', 'extra_details'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
