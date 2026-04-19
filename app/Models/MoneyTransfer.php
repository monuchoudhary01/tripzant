<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyTransfer extends Model
{
    protected $fillable = [
        'transfer_ref', 'user_id', 'type', 'source_currency', 'source_amount',
        'target_currency', 'target_amount', 'exchange_rate', 'fee',
        'provider_id', 'provider_reference', 'recipient_details', 'status', 'status_history', 'metadata'
    ];

    protected $casts = [
        'recipient_details' => 'array',
        'status_history' => 'array',
        'metadata' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(TransferProvider::class, 'provider_id');
    }
}
