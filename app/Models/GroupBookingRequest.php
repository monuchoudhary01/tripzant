<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupBookingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'passengers',
        'airline',
        'flight_number',
        'departure',
        'arrival',
        'date',
        'class',
        'remarks',
        'onward_details',
        'return_details',
        'multi_city_details',
    ];
}
