<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankOffer;
use Illuminate\Http\Request;

class BankOfferController extends Controller
{
    public function index()
    {
        $offers = BankOffer::orderBy('sort_order')->orderBy('bank_name')->get();
        return view('admin.bank-offers', compact('offers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bank_name'      => 'required|string|max:100',
            'display_name'   => 'required|string|max:150',
            'promo_code'     => 'nullable|string|max:50',
            'tagline'        => 'nullable|string|max:200',
            'color_code'     => 'nullable|string|max:10',
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_discount'   => 'nullable|numeric|min:0',
            'min_amount'     => 'nullable|numeric|min:0',
            'sort_order'     => 'nullable|integer',
            'is_active'      => 'nullable|boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('bank-logos', 'public');
            $data['logo'] = '/storage/' . $path;
        }

        $data['is_active'] = $request->boolean('is_active', true);

        BankOffer::create($data);

        return response()->json(['success' => true, 'message' => 'Bank offer created successfully.']);
    }

    public function update(Request $request, BankOffer $bankOffer)
    {
        $data = $request->validate([
            'bank_name'      => 'required|string|max:100',
            'display_name'   => 'required|string|max:150',
            'promo_code'     => 'nullable|string|max:50',
            'tagline'        => 'nullable|string|max:200',
            'color_code'     => 'nullable|string|max:10',
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_discount'   => 'nullable|numeric|min:0',
            'min_amount'     => 'nullable|numeric|min:0',
            'sort_order'     => 'nullable|integer',
            'is_active'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('bank-logos', 'public');
            $data['logo'] = '/storage/' . $path;
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $bankOffer->update($data);

        return response()->json(['success' => true, 'message' => 'Bank offer updated successfully.']);
    }

    public function toggleStatus(BankOffer $bankOffer)
    {
        $bankOffer->update(['is_active' => !$bankOffer->is_active]);
        return response()->json([
            'success'   => true,
            'is_active' => $bankOffer->is_active,
            'message'   => $bankOffer->is_active ? 'Offer activated.' : 'Offer deactivated.',
        ]);
    }

    public function destroy(BankOffer $bankOffer)
    {
        $bankOffer->delete();
        return response()->json(['success' => true, 'message' => 'Bank offer deleted.']);
    }
}
