<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoInsurance extends Model
{
    use HasFactory;

    protected $table = 'cargo_insurance';

    protected $fillable = [
        'booking_id', 'insurance_plan', 'coverage_amount', 'premium_paid'
    ];

    public function booking() {
        return $this->belongsTo(CargoBooking::class, 'booking_id');
    }
}
