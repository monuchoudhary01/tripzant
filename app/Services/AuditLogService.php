<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    /**
     * Log an activity to the audit_logs table.
     *
     * @param string $module Module name (e.g., Flight, Hotel, Auth)
     * @param string $action Action performed (e.g., Search, Login, Booking)
     * @param string $description Description of the activity
     * @param array|null $requestData JSON request data
     * @param array|null $responseData JSON response data
     * @param array|null $oldValues Old values (for updates)
     * @param array|null $newValues New values (for updates)
     * @return void
     */
    public static function log($module, $action, $description, $requestData = null, $responseData = null, $oldValues = null, $newValues = null)
    {
        try {
            $user = Auth::user();
            
            $userType = 'guest';
            $userName = 'Guest';
            $userId = null;

            if ($user) {
                $userId = $user->id;
                $userName = $user->name ?? $user->email ?? 'User ID: ' . $user->id;
                
                // Determine user type based on user properties or role
                // This is a simplified logic, adjust based on your app's user model
                if (isset($user->role)) {
                    $userType = $user->role;
                } elseif (strpos(Request::path(), 'admin') !== false) {
                    $userType = 'admin';
                } elseif (strpos(Request::path(), 'agent') !== false) {
                    $userType = 'agent';
                } elseif (strpos(Request::path(), 'corporate') !== false) {
                    $userType = 'corporate';
                } else {
                    $userType = 'user';
                }
            }

            AuditLog::create([
                'user_id' => $userId,
                'user_type' => $userType,
                'user_name' => $userName,
                'module' => $module,
                'action' => $action,
                'description' => $description,
                'request_data' => $requestData,
                'response_data' => $responseData,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => Request::ip(),
            ]);
        } catch (\Exception $e) {
            // Log error to laravel log if audit log fails
            \Log::error('Audit Log failed: ' . $e->getMessage());
        }
    }

    /**
     * Log an API request/response.
     */
    public static function logApi($provider, $endpoint, $method, $request = null, $response = null, $statusCode = null, $time = null, $clientRef = null, $headers = null, $timestamp = null)
    {
        try {
            $logData = [
                'provider' => $provider, // Matches database column 'provider' (old was api_provider in service, but migration says provider)
                'ama_client_ref' => $clientRef,
                'endpoint' => $endpoint,
                'method' => $method,
                'request_headers' => is_array($headers) ? json_encode($headers) : $headers,
                'request_payload' => is_array($request) ? json_encode($request) : $request,
                'response_payload' => is_array($response) ? json_encode($response) : $response, // Matches migration 'response_payload'
                'status_code' => $statusCode,
                'response_time' => $time, // Matches migration 'response_time'
                'created_at' => $timestamp ?: now()
            ];

            // Primary Log: Database
            \App\Models\ApiLog::create($logData);

            // Secondary Log: File (for debugging and easy sharing)
            \Log::info("API_LOG [{$provider}]", [
                'timestamp' => $timestamp ?: now()->toIso8601ZuluString(),
                'ama_client_ref' => $clientRef,
                'endpoint' => $endpoint,
                'method' => $method,
                'headers' => $headers,
                'request' => $request,
                'response' => $response,
                'status' => $statusCode,
                'time' => $time
            ]);

        } catch (\Exception $e) {
            \Log::error('API Log failed: ' . $e->getMessage());
        }
    }
}
