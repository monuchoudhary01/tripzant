<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 401);
        }

        if ($user->status === 'pending') {
            return response()->json(['success' => false, 'message' => 'Your account is under review.'], 403);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        $this->saveDeviceInfo($request, $user);

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }

    public function register(Request $request)
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
            'is_verified' => false,
            'otp' => '1234',
            'created_by' => 'self'
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;
        
        $this->saveDeviceInfo($request, $user);

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['phone' => 'required']);
        $user = User::where('phone', $request->phone)->first();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Mobile number not registered.'], 404);
        }

        $user->otp = '1234'; // Mock OTP
        $user->save();

        return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);

        $user = User::where('phone', $request->phone)->first();
        
        if ($user && ($request->otp === $user->otp || $request->otp === '1234')) {
            $token = $user->createToken('mobile-app')->plainTextToken;
            $this->saveDeviceInfo($request, $user);

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid OTP.'], 401);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email not registered.'], 404);
        }

        $user->otp = '1234'; // Mock OTP
        $user->save();

        return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user && ($request->otp === $user->otp || $request->otp === '1234')) {
            $user->password = Hash::make($request->password);
            $user->save();
            
            $token = $user->createToken('mobile-app')->plainTextToken;
            $this->saveDeviceInfo($request, $user);

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid OTP.'], 401);
    }

    private function saveDeviceInfo(Request $request, $user)
    {
        $deviceType = $request->header('device-type');
        $deviceToken = $request->header('device-token');
        $deviceLang = $request->header('device-lang', 'en');

        if ($deviceType || $deviceToken) {
            UserDevice::updateOrCreate(
                ['user_id' => $user->id, 'device_token' => $deviceToken],
                ['device_type' => $deviceType, 'device_lang' => $deviceLang]
            );
        }
    }
}
