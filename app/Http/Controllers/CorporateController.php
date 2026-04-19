<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

class CorporateController extends Controller
{
    /**
     * Corporate Dashboard (Admin/Employee Role based)
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Realstats
        $totalSpend = Booking::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->sum('selling_price');
            
        $pendingCount = Booking::where('user_id', $user->id) // In real app, might be filtered by company_id
            ->where('status', 'PENDING_APPROVAL')
            ->count();
            
        $totalBookings = Booking::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->count();
            
        $pendingRequests = Booking::where('user_id', $user->id)
            ->where('status', 'PENDING_APPROVAL')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('corporate.dashboard', compact('totalSpend', 'pendingCount', 'totalBookings', 'pendingRequests'));
    }

    /**
     * Flight Flow (Employee)
     */
    public function searchPage() { return view('corporate.search'); }
    public function flightListing() { return view('corporate.listing'); }
    public function paxDetails() { return view('corporate.pax-details'); }
    public function reviewPage() { return view('corporate.review'); }

    /**
     * Submit Booking Request (Employee -> Admin)
     */
    public function submitRequest(Request $request)
    {
        // Logic: Create a booking with status 'PENDING_APPROVAL'
        // This won't deduct money yet.
        AuditLogService::log('Corporate', 'Booking Request', 'Corporate employee submitted a booking request', $request->all());

        return redirect()->route('corporate.status', ['id' => rand(100, 999)])
                         ->with('success', 'Booking request submitted for Admin approval.');
    }

    public function requestStatus($id) { return view('corporate.status', compact('id')); }
    public function myTrips() { return view('corporate.status', ['id' => 'MY_TRIPS']); }

    /**
     * Admin Approvals
     */
    public function pendingApprovals() { return view('corporate.approvals'); }
    
    public function processApproval(Request $request, $id)
    {
        // Logic: Approve -> Deduct from Central Bill/Wallet -> Call GDS -> Issue Ticket
        AuditLogService::log('Corporate', 'Approval', 'Corporate admin approved a booking request', $request->all(), ['booking_id' => $id]);

        return back()->with('success', 'Booking approved and ticket issued successfully.');
    }

    public function processRejection(Request $request, $id)
    {
        return back()->with('error', 'Booking request has been rejected.');
    }

    public function allBookings() { return view('corporate.approvals'); }

    /**
     * Employee Management
     */
    public function manageEmployees() { return view('corporate.employees'); }
    public function addEmployeePage() { return view('corporate.employee-add'); }
    public function storeEmployee(Request $request)
    {
        return redirect()->route('corporate.employees.index')->with('success', 'Employee added to corporate account.');
    }

    /**
     * Policies & Budget
     */
    public function policySettings() { return view('corporate.policies'); }
    public function budgetLimits() { return view('corporate.budget'); }

    /**
     * Billing & Payments
     */
    public function invoices() { return view('corporate.billing'); }
    public function payments() { return view('corporate.billing'); }

    /**
     * Reports
     */
    public function expenseReports() { return view('corporate.reports-expense'); }
    public function bookingReports() { return view('corporate.reports-bookings'); }

    /**
     * Support & Account
     */
    public function supportHub() { return view('corporate.support'); }
    public function accountSettings() { return view('corporate.account'); }
}
