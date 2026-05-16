<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\App;
use App\Models\Country;
use App\Models\Currency;

class LocalizationController extends Controller
{
    public function setLocalization(Request $request)
    {
        $request->validate([
            'language_code' => 'required|string|size:2',
            'currency_code' => 'required|string|size:3',
            'country_code' => 'nullable|string|size:2',
        ]);

        $locale = strtolower($request->language_code);
        $currency = strtolower($request->currency_code);

        // Store in Session
        session([
            'user_language' => $locale,
            'user_currency' => strtoupper($currency),
            'user_country' => $request->country_code,
        ]);

        // Construct the new URL ( /{locale}/{currency}/{path} )
        $previousUrl = url()->previous();
        $parsedUrl = parse_url($previousUrl);
        $path = $parsedUrl['path'] ?? '';
        
        // Remove existing locale/currency from path if present (e.g. /en/aud/home -> /home)
        $segments = explode('/', trim($path, '/'));
        if (count($segments) >= 2 && strlen($segments[0]) == 2 && strlen($segments[1]) == 3) {
            array_shift($segments); // remove old lang
            array_shift($segments); // remove old curr
        }
        
        $newPath = implode('/', $segments);
        $redirectUrl = url("/{$locale}/{$currency}/" . ltrim($newPath, '/'));

        // For AJAX requests (from the modal)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'redirect' => $redirectUrl
            ])->withCookie(cookie()->forever('user_language', $locale))
              ->withCookie(cookie()->forever('user_currency', strtoupper($currency)));
        }

        return redirect($redirectUrl)
            ->withCookie(cookie()->forever('user_language', $locale))
            ->withCookie(cookie()->forever('user_currency', strtoupper($currency)));
    }
}
