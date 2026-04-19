<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homestay extends Model
{
    protected $fillable = ['title', 'city', 'image_url', 'price_per_night', 'description', 'is_active'];
}
