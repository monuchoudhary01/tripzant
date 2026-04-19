<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarePriceLog extends Model
{
    protected $fillable = ['fare_alert_id', 'price', 'checked_at'];

    protected $casts = [
        'checked_at' => 'datetime',
    ];

    public function alert()
    {
        return $this->belongsTo(FareAlert::class, 'fare_alert_id');
    }
}
