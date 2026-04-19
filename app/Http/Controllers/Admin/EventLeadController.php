<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventLead;

class EventLeadController extends Controller
{
    public function index()
    {
        $leads = EventLead::orderBy('created_at', 'desc')->get();
        return view('admin.event-leads', compact('leads'));
    }

    public function destroy($id)
    {
        EventLead::destroy($id);
        return back()->with('success', 'Lead deleted successfully.');
    }
}
