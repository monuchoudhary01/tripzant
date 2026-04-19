<?php

namespace App\Models\Accounting;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'accounting_invoices';
    protected $fillable = [
        'invoice_number', 'booking_id', 'user_id', 'invoice_date', 
        'due_date', 'subtotal', 'tax_amount', 'total_amount', 
        'amount_paid', 'status'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
