<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'user_name',
        'module',
        'action',
        'description',
        'request_data',
        'response_data',
        'old_values',
        'new_values',
        'ip_address',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'old_values' => 'array',
        'new_values' => 'array',
    ];
}
