<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FareAlert extends Model
{
    protected $fillable = [
        'agent_id', 'origin', 'destination', 'travel_date', 'pax', 
        'target_price', 'auto_book', 'passenger_details', 'status', 'notification_channel', 'matched_data', 'last_checked_at'
    ];

    protected $casts = [
        'matched_data' => 'array',
        'passenger_details' => 'array',
        'auto_book' => 'boolean',
        'last_checked_at' => 'datetime',
        'travel_date' => 'date',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function priceLogs()
    {
        return $this->hasMany(FarePriceLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(FareNotification::class);
    }
}
