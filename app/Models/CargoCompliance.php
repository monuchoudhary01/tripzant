<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoCompliance extends Model
{
    use HasFactory;

    protected $table = 'cargo_compliance_checks';

    protected $fillable = ['shipment_id', 'is_allowed', 'declarations', 'remarks'];

    protected $casts = [
        'declarations' => 'array'
    ];
}
