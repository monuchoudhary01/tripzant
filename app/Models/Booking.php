<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'booking_reference', 'type', 'total_amount', 'currency', 'status', 'api_booking_details'
    ];

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
}
