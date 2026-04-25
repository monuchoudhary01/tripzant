<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

class AuthController extends Controller
{
    public function loginUnified(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        if ($user->status === 'pending') {
            return response()->json(['success' => false, 'message' => 'Your account is under review.']);
        }

        // Restrict to Customer (role_id 3)
        if ($user->role_id != 3) {
            return response()->json(['success' => false, 'message' => 'This account is not authorized for Customer Login. Please use the Partner or Admin portal.']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            AuditLogService::log('Auth', 'Unified Login', 'User logged in: ' . $user->name, null, ['role' => $user->role]);

            // Support both session intended and manual redirect_to parameter
            // PRIORITY: If redirect_to is passed explicitly (e.g. from AJAX modal), use it.
            $redirect_to = $request->input('redirect_to');
            $intended = session()->pull('url.intended');
            // FIX: Prioritize intended URL (like checkout) over the current page (which might be the home page where the modal is)
            $redirectUrl = $intended ?: ($redirect_to ?: $this->getRedirectUrl($user->role));

            return response()->json(['success' => true, 'redirect' => $redirectUrl]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid password.']);
    }

    /**
     * Show Login Forms for various roles
     */
    public function showUserLogin() { return redirect('/')->with('showLoginModal', true); }
    public function showAdminLogin() { return view('auth.admin-login', ['role' => 'admin', 'title' => 'Tripzant Admin Portal']); }
    public function showPartnerLogin() { return view('auth.login', ['role' => 'amadeus-partner', 'title' => 'Amadeus GDS Partner Login']); }
    public function showIataLogin() { return view('auth.login', ['role' => 'iata', 'title' => 'IATA Agent Login']); }
    public function showCorporateLogin() { return view('auth.login', ['role' => 'corporate', 'title' => 'Corporate Login']); }
    public function showAgentLogin() { return view('auth.login', ['role' => 'b2b', 'title' => 'B2B Agent Login']); }
    public function showSupplierLogin() { return view('auth.login', ['role' => 'supplier', 'title' => 'Tour Supplier Login']); }
    public function showCargoLogin() { return view('auth.login', ['role' => 'cargo', 'title' => 'Cargo Partner Login']); }

    public function showPartnerSignup() { return view('auth.partner-signup'); }

    /**
     * Signup Forms
     */
    public function showUserRegister() { return redirect('/')->with('showSignupModal', true); }

    /**
     * Login Handlers
     */
    public function login(Request $request) { return $this->handleLogin($request, 'user'); }
    public function loginAdmin(Request $request) { return $this->handleLogin($request, 'admin'); }
    
    public function handlePartnerLogin(Request $request) 
    {
        $user = User::where('email', $request->email)->first();
        
        // Restrict to Partners (role_id 4 to 12)
        if (!$user || $user->role_id < 4 || $user->role_id > 12) {
            return response()->json(['success' => false, 'message' => 'This account is not authorized for the Partner Portal.']);
        }

        return $this->handleLogin($request, $user->role);
    }

    private function handleLogin(Request $request, $expectedRole)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials or user does not exist.']);
        }

        // Check Role
        $isAuthorized = ($user->role === $expectedRole);
        
        // Special case: Only Super Admin (role_id 1) can access admin portal
        if ($expectedRole === 'admin') {
            if ($user->role_id == 1) {
                $isAuthorized = true;
            } else {
                $isAuthorized = false;
            }
        }

        if (!$isAuthorized && $expectedRole !== 'user') {
            return response()->json(['success' => false, 'message' => 'This account is not authorized for this portal.']);
        }

        if ($user->status === 'pending') {
            return response()->json(['success' => false, 'message' => 'Your account is under review. Please wait for admin approval.']);
        }

        if ($user->status === 'rejected') {
            return response()->json(['success' => false, 'message' => 'Your account was rejected. Please contact support.']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            AuditLogService::log('Auth', 'Login', 'User logged in: ' . $user->name, null, ['role' => $user->role]);

            // Support both session intended and manual redirect_to
            $redirect_to = $request->input("redirect_to"); 
            $intended = session()->pull("url.intended");
            $redirectUrl = $intended ?: ($redirect_to ?: $this->getRedirectUrl($user->role));

            return response()->json(['success' => true, 'redirect' => $redirectUrl]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid password.']);
    }

    private function getRedirectUrl($role)
    {
        switch ($role) {
            case 'admin':
            case 'super-admin': return '/admin-dashboard';
            case 'amadeus-partner': return '/amadeus-dashboard';
            case 'iata': return '/iata-dashboard';
            case 'corporate': return '/corporate';
            case 'b2b': return '/agent-dashboard';
            case 'supplier': return '/tourbuilder-dashboard';
            case 'cargo': return '/cargo-dashboard';
            default: return '/';
        }
    }

    /**
     * Registration Handlers
     */
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);

        $role = \App\Models\Role::where('slug', 'user')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'role_id' => $role ? $role->id : null,
            'status' => 'active',
            'is_verified' => false, // Require OTP
            'otp' => '1234', // Default for now
            'created_by' => 'self'
        ]);

        \App\Http\Controllers\AffiliateController::trackReferral($user);

        return response()->json(['success' => true, 'user_id' => $user->id]);
    }

    public function loginSendOtp(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Mobile number not registered.']);
        }

        // Mock OTP send
        $user->otp = '1234';
        $user->save();

        return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
    }

    public function loginVerifyOtp(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if ($user && ($request->otp === $user->otp || $request->otp === '1234')) {
            // Restrict to Customer (role_id 3)
            if ($user->role_id != 3) {
                return response()->json(['success' => false, 'message' => 'Unauthorized access for this portal.']);
            }

            Auth::login($user);
            $request->session()->regenerate();
            AuditLogService::log('Auth', 'OTP Login', 'User logged in via phone: ' . $user->phone, null, ['role' => $user->role]);

            // Support both session intended and manual redirect_to
            $redirect_to = $request->input("redirect_to"); 
            $intended = session()->pull("url.intended");
            $redirectUrl = $intended ?: ($redirect_to ?: $this->getRedirectUrl($user->role));

            return response()->json(['success' => true, 'redirect' => $redirectUrl]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid OTP.']);
    }

    public function forgotPasswordOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email not registered.']);
        }

        // Mock OTP send
        $user->otp = '1234';
        $user->save();

        return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
    }

    public function resetPasswordOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user && ($request->otp === $user->otp || $request->otp === '1234')) {
            // Restrict to Customer (role_id 3) as this is usually called from Customer Forgot Pass
            if ($user->role_id != 3) {
                return response()->json(['success' => false, 'message' => 'Unauthorized access.']);
            }

            $user->password = Hash::make($request->password);
            $user->save();
            Auth::login($user);
            $request->session()->regenerate();

            $redirect_to = $request->input('redirect_to');
            $intended = session()->pull('url.intended');
            $redirectUrl = $intended ?: ($redirect_to ?: $this->getRedirectUrl($user->role));

            return response()->json(['success' => true, 'redirect' => $redirectUrl]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid OTP.']);
    }

    public function handlePartnerRegistration(Request $request)
    {
        $request->validate([
            'business_name' => 'required',
            'contact_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'role' => 'required|in:b2b,corporate,supplier,hotel-partner,cargo,affiliate', 
            'password' => 'required|min:6|confirmed'
        ]);

        // Capture dynamic fields into business_metadata
        $exclude = ['_token', 'business_name', 'contact_name', 'email', 'phone', 'role', 'password', 'password_confirmation', 'service_category', 'pricing', 'location'];
        $metadata = array_diff_key($request->all(), array_flip($exclude));

        $roleModel = \App\Models\Role::where('slug', $request->role)->first();

        $user = User::create([
            'name' => $request->contact_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'role_id' => $roleModel ? $roleModel->id : null,
            'status' => 'pending',
            'agency_name' => $request->business_name,
            'company_name' => $request->business_name,
            'gst_number' => $request->gst_number,
            'service_category' => $request->service_category,
            'pricing' => $request->pricing,
            'provider_location' => $request->location,
            'business_metadata' => $metadata,
            'created_by' => 'self'
        ]);

        \App\Http\Controllers\AffiliateController::trackReferral($user);

        AuditLogService::log('Auth', 'Register', 'New partner registration: ' . $request->business_name, null, ['role' => $request->role, 'email' => $request->email]);

        return response()->json([
            'success' => true, 
            'message' => 'Successfully registered! Your application is now in review. You will get notified via email once approved.'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user && ($request->otp == $user->otp || $request->otp == '1234')) {
            $user->is_verified = true;
            $user->save();
            Auth::login($user);
            $request->session()->regenerate();

            $redirect_to = $request->input('redirect_to');
            $intended = session()->pull('url.intended');
            $redirectUrl = $intended ?: ($redirect_to ?: $this->getRedirectUrl($user->role));

            return response()->json(['success' => true, 'redirect' => $redirectUrl]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid OTP']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
