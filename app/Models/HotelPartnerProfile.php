<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HotelPartnerProfile extends Model { protected $fillable = ['user_id', 'property_name', 'property_type', 'star_rating', 'address', 'gst_number']; }
