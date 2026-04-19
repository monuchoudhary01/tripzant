<?php

namespace App\Models\Accounting;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $table = 'accounting_journal_entries';
    protected $fillable = ['entry_date', 'reference_type', 'reference_id', 'description', 'created_by'];

    public function ledgerEntries()
    {
        return $this->hasMany(LedgerEntry::class, 'journal_entry_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
