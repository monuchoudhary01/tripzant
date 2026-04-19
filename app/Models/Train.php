<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $fillable = [
        'train_number', 'train_name', 'origin', 'destination', 
        'departure_time', 'arrival_time', 'base_fare', 'classes', 
        'days_running', 'is_active'
    ];

    protected $casts = [
        'classes' => 'array'
    ];
}
