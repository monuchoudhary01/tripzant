<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class LedgerEntry extends Model
{
    protected $table = 'accounting_ledger_entries';
    protected $fillable = ['journal_entry_id', 'account_id', 'debit', 'credit', 'description'];

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
