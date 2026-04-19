<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentDocument extends Model
{
    use HasFactory;

    protected $fillable = ['shipment_id', 'document_type', 'file_path'];
}
