<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->status === 'pending') {
                auth()->logout();
                return redirect()->route('login')->with('error', 'Your account is under review. You will be notified once it is approved.');
            }
            if ($user->status === 'rejected') {
                auth()->logout();
                return redirect()->route('login')->with('error', 'Your application has been rejected. Please contact support.');
            }
        }

        return $next($request);
    }
}
