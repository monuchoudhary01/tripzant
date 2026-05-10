<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WalletTransaction;

class AdminWalletController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['b2b', 'supplier', 'agent'])->get();
        return view('admin.wallet.index', compact('users'));
    }

    public function updateBalance(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:credit,debit',
            'remarks' => 'nullable|string'
        ]);

        $user = User::find($request->user_id);
        if ($request->type === 'credit') {
            $user->balance += $request->amount;
        } else {
            $user->balance -= $request->amount;
        }
        $user->save();

        WalletTransaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => $request->type,
            'remarks' => $request->remarks,
            'balance_after' => $user->balance
        ]);

        return back()->with('success', 'Balance updated successfully');
    }

    public function transactions($id)
    {
        $user = User::findOrFail($id);
        $transactions = WalletTransaction::where('user_id', $id)->latest()->paginate(20);
        return view('admin.wallet.transactions', compact('user', 'transactions'));
    }
}
