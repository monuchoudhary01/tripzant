<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'booking_reference', 'type', 'total_amount', 'currency', 'status', 'api_booking_details'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function flightBooking()
    {
        return $this->hasOne(FlightBooking::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
}
