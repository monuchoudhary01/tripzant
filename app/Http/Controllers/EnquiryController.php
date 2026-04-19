<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Enquiry;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $enquiry = Enquiry::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'details' => json_encode($request->except(['_token', 'type', 'name', 'email', 'phone'])),
            'status' => 'new'
        ]);

        AuditLogService::log(
            'ENQUIRY_SUBMITTED',
            "New enquiry for {$request->type} submitted by {$request->email}",
            ['enquiry_id' => $enquiry->id]
        );

        return response()->json(['success' => true, 'message' => 'Your request has been submitted. Our team will contact you shortly.', 'id' => $enquiry->id]);
    }

    public function adminIndex()
    {
        $enquiries = Enquiry::with('user')->latest()->get();
        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function updateStatus(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update(['status' => $request->status, 'admin_note' => $request->note]);
        
        return back()->with('success', 'Enquiry status updated.');
    }
}
