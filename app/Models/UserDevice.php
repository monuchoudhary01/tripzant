<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $fillable = [
        'user_id',
        'device_type',
        'device_token',
        'device_lang'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
