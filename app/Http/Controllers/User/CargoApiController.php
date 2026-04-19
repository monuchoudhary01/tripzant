<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CargoApiController extends Controller
{
    public function index() {
        $requestData = DB::table('cargo_api_requests')->where('user_id', auth()->id())->first();
        $credentials = DB::table('cargo_api_credentials')->where('user_id', auth()->id())->first();
        
        return view('cargo.agent.api.index', compact('requestData', 'credentials'));
    }

    public function requestAccess(Request $request) {
        $request->validate([
            'company_name' => 'required',
            'contact_person' => 'required',
            'phone' => 'required',
        ]);

        DB::table('cargo_api_requests')->insert([
            'user_id' => auth()->id(),
            'company_name' => $request->company_name,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'tech_stack' => $request->tech_stack,
            'requirements' => $request->requirements,
            'status' => 'Pending',
            'created_at' => now(),
        ]);

        return back()->with('success', 'API request submitted! We will review and generate keys.');
    }

    public function generateKeys(Request $request) {
        // Admin only or mock for now
        $apiKey = 'trip_live_' . Str::random(32);
        $apiSecret = Str::random(64);

        DB::table('cargo_api_credentials')->updateOrInsert(
            ['user_id' => auth()->id()],
            [
                'api_key' => $apiKey,
                'api_secret' => $apiSecret,
                'is_active' => true,
                'created_at' => now()
            ]
        );

        DB::table('cargo_api_requests')->where('user_id', auth()->id())->update(['status' => 'Approved']);

        return back()->with('success', 'Keys generated successfully!');
    }
}
