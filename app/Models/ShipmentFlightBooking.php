<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentFlightBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id', 'flight_number', 'pnr', 'departure', 'arrival',
        'internal_cost', 'internal_commission', 'flight_data'
    ];

    protected $casts = [
        'departure' => 'datetime',
        'arrival' => 'datetime',
        'flight_data' => 'array',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
