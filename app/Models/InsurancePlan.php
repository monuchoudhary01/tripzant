<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsurancePlan extends Model
{
    protected $fillable = ['plan_name', 'coverage_type', 'price', 'benefits', 'provider', 'is_active'];
}
