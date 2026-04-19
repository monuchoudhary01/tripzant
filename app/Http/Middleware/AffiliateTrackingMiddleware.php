<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AffiliateTrackingMiddleware
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
        if ($request->has('ref')) {
            $ref = $request->input('ref');
            // Store cookie for 30 days
            Cookie::queue('referred_by', $ref, 60 * 24 * 30);
        }

        return $next($request);
    }
}
