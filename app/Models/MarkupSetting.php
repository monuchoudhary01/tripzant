<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkupSetting extends Model
{
    protected $fillable = ['module', 'user_role', 'markup_type', 'markup_value', 'is_active'];
}
