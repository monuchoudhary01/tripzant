<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoTransaction extends Model
{
    use HasFactory;

    protected $table = 'cargo_transactions';

    protected $fillable = [
        'booking_id', 'transaction_id', 'payment_gateway', 'amount', 'status'
    ];

    public function booking() {
        return $this->belongsTo(CargoBooking::class, 'booking_id');
    }
}
