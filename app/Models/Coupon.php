<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'title', 'description', 'discount_amount', 'discount_type', 'expiry_date', 'is_active'];
}
