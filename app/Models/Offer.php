<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'image_url', 'promo_code', 'color_code', 'discount_text',
        'link_url', 'category', 'is_active', 'sort_order',
        'bank_name', 'card_type', 'discount_value', 'discount_type',
        'max_discount', 'min_amount', 'valid_till'
    ];

    public function getDisplayNameAttribute()
    {
        return $this->bank_name ?: $this->title;
    }

    public function getTaglineAttribute()
    {
        return $this->description ?: $this->discount_text;
    }

    public function getLogoAttribute()
    {
        return $this->image_url;
    }
}
