<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoBooking extends Model
{
    use HasFactory;

    protected $table = 'cargo_bookings';

    protected $fillable = [
        'booking_ref', 'tracking_id', 'user_id', 'provider_id',
        'origin_country', 'origin_city', 'destination_country', 'destination_city',
        'parcel_type', 'weight', 'dimensions', 'urgency',
        'base_price', 'insurance_fee', 'tax_fee', 'discount_amount', 'total_price',
        'currency', 'status', 'sender_details', 'receiver_details', 'pickup_option'
    ];

    protected $casts = [
        'dimensions' => 'array',
        'sender_details' => 'array',
        'receiver_details' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function provider() {
        return $this->belongsTo(CargoProvider::class, 'provider_id');
    }

    public function tracking() {
        return $this->hasMany(CargoTracking::class, 'booking_id');
    }

    public function customs() {
        return $this->hasOne(CargoCustomsDeclaration::class, 'booking_id');
    }

    public function insurance() {
        return $this->hasOne(CargoInsurance::class, 'booking_id');
    }

    public function transaction() {
        return $this->hasOne(CargoTransaction::class, 'booking_id');
    }
}
