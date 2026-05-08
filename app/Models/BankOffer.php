<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'display_name',
        'promo_code',
        'tagline',
        'logo',
        'color_code',
        'discount_type',
        'discount_value',
        'max_discount',
        'min_amount',
        'is_active',
        'sort_order',
    ];
}
