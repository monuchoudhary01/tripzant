<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'next_visit_sri_lanka',
        'next_holiday_destination',
        'wants_tour_builder',
        'event_name',
        'additional_notes',
        'raffle_alphabetic',
        'raffle_number',
        'raffle_colour',
        'raffle_code'
    ];
    use HasFactory;
}
