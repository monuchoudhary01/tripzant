<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounting_accounts';
    protected $fillable = ['name', 'code', 'type', 'balance', 'is_system'];

    const TYPE_ASSET = 'asset';
    const TYPE_LIABILITY = 'liability';
    const TYPE_EQUITY = 'equity';
    const TYPE_REVENUE = 'revenue';
    const TYPE_EXPENSE = 'expense';

    public function ledgerEntries()
    {
        return $this->hasMany(LedgerEntry::class, 'account_id');
    }
}
