<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin', 'destination', 'base_fee', 'rate_per_kg',
        'express_multiplier', 'min_days', 'max_days', 'is_active'
    ];
}
