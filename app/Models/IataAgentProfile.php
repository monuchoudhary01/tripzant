<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class IataAgentProfile extends Model { protected $fillable = ['user_id', 'iata_code', 'agency_name', 'license_no', 'office_address']; }
