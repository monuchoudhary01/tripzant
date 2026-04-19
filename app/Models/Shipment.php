<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'shipment_id', 'pickup_city', 'delivery_city', 'weight',
        'package_type', 'status', 'price', 'flight_id', 'sender_details', 'receiver_details'
    ];

    protected $casts = [
        'sender_details' => 'array',
        'receiver_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tracking()
    {
        return $this->hasMany(ShipmentTracking::class);
    }

    public function flight()
    {
        return $this->hasOne(ShipmentFlightBooking::class);
    }
}
