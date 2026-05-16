<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class RegionalContextMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Get from URL parameters first (new structure)
        $locale = $request->route('locale');
        $currency = $request->route('currency');

        // 2. Fallback to Session or Default if not in URL
        if (!$locale) {
            $locale = Session::get('user_locale', 'en');
        }
        if (!$currency) {
            $currency = Session::get('user_currency', 'AUD');
        }

        // Validate and Normalize
        $locale = strtolower($locale);
        $currency = strtoupper($currency);

        // 3. Persist to Session for helpers
        Session::put('user_locale', $locale);
        Session::put('user_language', $locale);
        Session::put('user_currency', $currency);
        
        App::setLocale($locale);

        // Share globally with Blade
        View::share('currentLocale', $locale);
        View::share('currentCurrency', $currency);

        // 4. Share with Views Globally
        $allCountries = \App\Models\Country::all();
        $allCurrencies = \App\Models\Currency::all();
        $allLanguages = \App\Models\Language::all();
        
        View::share('global_lang', $locale);
        View::share('global_country', Session::get('user_country', 'AU'));
        View::share('global_currency', $currency);
        View::share('global_timezone', Session::get('user_timezone', 'UTC'));
        View::share('all_countries', $allCountries);
        View::share('all_currencies', $allCurrencies);
        View::share('all_languages', $allLanguages);

        return $next($request);
    }
}
