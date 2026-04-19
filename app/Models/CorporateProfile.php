<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CorporateProfile extends Model { protected $fillable = ['user_id', 'company_name', 'registration_no', 'travel_policy']; }
