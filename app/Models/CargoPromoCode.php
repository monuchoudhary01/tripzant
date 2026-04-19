<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoPromoCode extends Model
{
    use HasFactory;

    protected $table = 'cargo_promo_codes';

    protected $fillable = [
        'code', 'type', 'value', 'min_booking_value', 'expiry_date', 'is_active'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];
}
