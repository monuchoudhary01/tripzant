<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Support\Facades\Cache;

class LocalizationController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        $currencies = Currency::all();
        $languages = Language::all();
        $translations = LanguageLine::orderBy('group')->orderBy('key')->paginate(50);

        return view('admin.localization.index', compact('countries', 'currencies', 'languages', 'translations'));
    }

    // --- TRANSLATIONS ---
    public function storeTranslation(Request $request)
    {
        $request->validate([
            'group' => 'required|string',
            'key' => 'required|string',
            'text' => 'required|array'
        ]);

        LanguageLine::updateOrCreate(
            ['group' => $request->group, 'key' => $request->key],
            ['text' => $request->text]
        );
        Cache::forget('spatie.translation-loader.dummy'); // Flush translation cache

        return redirect()->back()->with('success', 'Translation saved successfully.');
    }

    public function destroyTranslation($id)
    {
        LanguageLine::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Translation deleted successfully.');
    }

    // --- COUNTRIES ---
    public function storeCountry(Request $request)
    {
        $request->validate([
            'iso_code' => 'required|string|size:2',
            'name' => 'required|string',
            'currency_code' => 'required|string|size:3',
            'timezone' => 'required|string',
        ]);

        Country::updateOrCreate(
            ['iso_code' => strtoupper($request->iso_code)],
            $request->only('name', 'currency_code', 'timezone', 'language_code', 'is_active')
        );

        return redirect()->back()->with('success', 'Country saved successfully.');
    }

    public function destroyCountry($id)
    {
        Country::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Country deleted successfully.');
    }

    // --- CURRENCIES ---
    public function storeCurrency(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:3',
            'symbol' => 'required|string',
            'exchange_rate' => 'required|numeric',
        ]);

        Currency::updateOrCreate(
            ['code' => strtoupper($request->code)],
            $request->only('symbol', 'exchange_rate', 'is_active')
        );

        return redirect()->back()->with('success', 'Currency saved successfully.');
    }

    public function destroyCurrency($id)
    {
        Currency::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Currency deleted successfully.');
    }

    // --- LANGUAGES ---
    public function storeLanguage(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:2',
            'name' => 'required|string',
        ]);

        Language::updateOrCreate(
            ['code' => strtolower($request->code)],
            $request->only('name', 'is_active')
        );

        return redirect()->back()->with('success', 'Language saved successfully.');
    }

    public function destroyLanguage($id)
    {
        Language::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Language deleted successfully.');
    }
}
