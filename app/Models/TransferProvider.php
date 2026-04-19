<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferProvider extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'supported_currencies', 'base_fee', 
        'fee_percentage', 'estimated_delivery_minutes', 'is_active', 'config'
    ];

    protected $casts = [
        'supported_currencies' => 'array',
        'config' => 'array'
    ];
}
