<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoRoute extends Model
{
    use HasFactory;

    protected $fillable = ['from_city', 'to_city', 'is_available', 'pickup_partner_id', 'delivery_partner_id'];
}
