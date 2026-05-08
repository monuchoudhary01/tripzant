<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RestrictToPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $path = $request->getPathInfo();
            $dashboardUrl = $user->getDashboardUrl();

            // 1. Allow basic utility routes and Money Transfer for all authenticated users
            $utilityRoutes = [
                '/logout', '/clear-cache', '/verify-otp', '/login', '/money-transfer'
            ];
            
            if (in_array($path, $utilityRoutes) || str_starts_with($path, '/money-transfer')) {
                 return $next($request);
            }

            // 2. Define Panel Prefixes and required roles
            $panelMapping = [
                '/admin-dashboard'      => User::ROLE_ADMIN,
                '/admin'                => User::ROLE_ADMIN,
                '/accounting'           => [User::ROLE_ADMIN, User::ROLE_ACCOUNTING],
                '/agent-dashboard'      => User::ROLE_AGENT,
                '/iata-dashboard'       => User::ROLE_IATA,
                '/amadeus-dashboard'    => User::ROLE_AMADEUS_PARTNER,
                '/corporate'            => User::ROLE_CORPORATE,
                '/corporate-dashboard'  => User::ROLE_CORPORATE,
                '/hotel-dashboard'      => User::ROLE_HOTEL_PARTNER,
                '/tourbuilder-dashboard'=> User::ROLE_TOUR_BUILDER,
                '/cargo-dashboard'      => User::ROLE_CARGO,
                '/cargo-agent'          => [User::ROLE_AGENT, User::ROLE_CARGO],
                '/cargo-hub'            => [User::ROLE_ADMIN, User::ROLE_CARGO],
                '/dashboard'            => [User::ROLE_USER, User::ROLE_ADMIN],
                '/user-cargo'           => [User::ROLE_USER, User::ROLE_CARGO],
                '/partner'              => User::ROLE_TOUR_BUILDER,
                '/agent'                => User::ROLE_IATA,
                '/affiliate-dashboard'  => User::ROLE_AFFILIATE,
                '/investor'             => [User::ROLE_INVESTOR, User::ROLE_ADMIN],
                '/visa'                 => [User::ROLE_VISA_PROVIDER, User::ROLE_ADMIN],
                '/local-provider'       => [User::ROLE_LOCAL_PROVIDER, User::ROLE_ADMIN],
            ];

            // 3. Check if user is accessing a panel and if they are authorized
            $isAccessingPanel = false;
            $accessAllowed = false;

            foreach ($panelMapping as $prefix => $role) {
                if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                    $isAccessingPanel = true;
                    if (is_array($role)) {
                        if (in_array($user->role, $role)) $accessAllowed = true;
                    } else {
                        if ($user->role === $role) $accessAllowed = true;
                    }
                    break;
                }
            }

            // 4. Enforcement Phase
            if ($isAccessingPanel) {
                // If user is authorized for this panel, let them through
                if ($accessAllowed) {
                    return $next($request);
                } else {
                    // ACCESS DENIED: User is in a panel they don't belong to.
                    // Redirect to THEIR OWN assigned dashboard.
                    return redirect($dashboardUrl);
                }
                // Allow B2C Customers, B2B Agents & Affiliates to browse the frontend/booking pages
                $allowedOnFrontend = [
                    User::ROLE_USER, 
                    User::ROLE_AFFILIATE, 
                    User::ROLE_AGENT, 
                    User::ROLE_IATA,
                    User::ROLE_CORPORATE
                ];

                if (in_array($user->role, $allowedOnFrontend)) {
                    return $next($request);
                }

                // FORBIDDEN: Partner/Admin users are strictly restricted to their control panels.
                return redirect($dashboardUrl);
            }
        }

        return $next($request);
    }
}
