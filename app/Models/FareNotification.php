<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FareNotification extends Model
{
    protected $fillable = ['fare_alert_id', 'type', 'status', 'sent_at'];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function alert()
    {
        return $this->belongsTo(FareAlert::class, 'fare_alert_id');
    }
}
