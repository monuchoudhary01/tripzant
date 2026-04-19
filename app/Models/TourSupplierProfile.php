<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourSupplierProfile extends Model
{
    protected $fillable = ['user_id', 'company_name', 'license_no', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
