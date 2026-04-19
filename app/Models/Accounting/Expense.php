<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'accounting_expenses';
    protected $fillable = ['title', 'account_id', 'amount', 'expense_date', 'payment_method', 'receipt_path', 'notes'];

    protected $casts = [
        'expense_date' => 'date'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
