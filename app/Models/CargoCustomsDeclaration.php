<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoCustomsDeclaration extends Model
{
    use HasFactory;

    protected $table = 'cargo_customs_declarations';

    protected $fillable = [
        'booking_id', 'item_description', 'declared_value', 'category',
        'invoice_url', 'no_dangerous_goods', 'digital_signature', 'customs_status'
    ];

    protected $casts = [
        'no_dangerous_goods' => 'boolean',
    ];

    public function booking() {
        return $this->belongsTo(CargoBooking::class, 'booking_id');
    }
}
