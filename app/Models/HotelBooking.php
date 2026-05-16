<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBooking extends Model
{
    protected $fillable = [
        'booking_id', 'hotel_code', 'hotel_name', 'check_in', 'check_out', 
        'rooms', 'guests', 'room_type', 'confirmation_number', 'hotel_details'
    ];
}
