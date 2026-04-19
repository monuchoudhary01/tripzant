<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EsimPlan extends Model
{
    protected $fillable = ['country', 'country_code', 'region', 'data_allowance', 'validity', 'price', 'provider', 'is_active'];
}
