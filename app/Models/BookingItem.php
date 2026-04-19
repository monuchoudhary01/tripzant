<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    protected $fillable = [
        'booking_id', 'item_name', 'item_type', 'amount', 'details'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
