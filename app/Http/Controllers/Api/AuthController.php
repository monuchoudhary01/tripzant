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
    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     summary="User Login",
     *     description="Login with email and password to receive a Bearer Token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="token", type="string", example="1|abc..."),
     *             @OA\Property(property="user", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Authentication"},
     *     summary="User Registration",
     *     description="Register a new user and receive an OTP",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","phone","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="9876543210"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OTP sent successfully")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/login/otp/send",
     *     tags={"Authentication"},
     *     summary="Send Login OTP",
     *     description="Send a 4-digit OTP to the user's mobile for login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"phone"},
     *             @OA\Property(property="phone", type="string", example="9876543210")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OTP sent successfully")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/login/otp/verify",
     *     tags={"Authentication"},
     *     summary="Verify Login OTP",
     *     description="Verify mobile OTP to receive a Bearer Token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"phone","otp"},
     *             @OA\Property(property="phone", type="string", example="9876543210"),
     *             @OA\Property(property="otp", type="string", example="1234")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successful")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/password/forgot",
     *     tags={"Authentication"},
     *     summary="Forgot Password",
     *     description="Request an OTP for password reset",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OTP sent successfully")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/password/reset",
     *     tags={"Authentication"},
     *     summary="Reset Password",
     *     description="Reset password using OTP",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","otp","password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="otp", type="string"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Password reset successful")
     * )
     */
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
