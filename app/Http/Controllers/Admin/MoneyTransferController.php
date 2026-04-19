<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MoneyTransfer;
use App\Models\TransferProvider;
use Illuminate\Http\Request;

class MoneyTransferController extends Controller
{
    public function index()
    {
        $transfers = MoneyTransfer::with(['user', 'provider'])->latest()->paginate(20);
        return view('admin.money-transfer.index', compact('transfers'));
    }

    public function providers()
    {
        $providers = TransferProvider::all();
        return view('admin.money-transfer.providers', compact('providers'));
    }

    public function updateProvider(Request $request, $id)
    {
        $provider = TransferProvider::findOrFail($id);
        $provider->update($request->all());
        return back()->with('success', 'Provider updated successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $transfer = MoneyTransfer::findOrFail($id);
        $transfer->update(['status' => $request->status]);
        return back()->with('success', 'Transfer status updated');
    }
}
