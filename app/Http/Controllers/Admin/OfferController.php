<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $query = Offer::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $offers = $query->orderBy('sort_order')->paginate(20);
        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admin.offers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('offers', 'public');
            $data['image_url'] = Storage::url($path);
        }

        Offer::create($data);

        return redirect()->route('admin.offers.index')->with('success', 'Offer created successfully.');
    }

    public function edit(Offer $offer)
    {
        return view('admin.offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_file')) {
            // Delete old image if it was uploaded
            if (strpos($offer->image_url, '/storage/') !== false) {
                $oldPath = str_replace('/storage/', '', $offer->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('image_file')->store('offers', 'public');
            $data['image_url'] = Storage::url($path);
        }

        $offer->update($data);

        return redirect()->route('admin.offers.index')->with('success', 'Offer updated successfully.');
    }

    public function destroy(Offer $offer)
    {
        if (strpos($offer->image_url, '/storage/') !== false) {
            $oldPath = str_replace('/storage/', '', $offer->image_url);
            Storage::disk('public')->delete($oldPath);
        }
        $offer->delete();
        return redirect()->route('admin.offers.index')->with('success', 'Offer deleted successfully.');
    }

    public function toggleStatus(Offer $offer)
    {
        $offer->is_active = !$offer->is_active;
        $offer->save();
        return back()->with('success', 'Status updated.');
    }
}
