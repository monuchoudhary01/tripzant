<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\GlobalSetting;
use App\Models\MarkupSetting;

class SystemSettingsController extends Controller
{
    public function index()
    {
        // Ensure all service keys exist
        $serviceKeys = [
            'service_flights_enabled', 'service_hotels_enabled', 'service_flight_hotel_enabled',
            'service_homestays_enabled', 'service_cabs_enabled', 'service_trains_enabled',
            'service_holidays_enabled', 'service_visa_enabled', 'service_insurance_enabled',
            'service_esim_enabled', 'service_cargo_enabled', 'service_event_qr_enabled'
        ];

        foreach ($serviceKeys as $key) {
            if (!GlobalSetting::where('key', $key)->exists()) {
                GlobalSetting::create([
                    'key' => $key,
                    'value' => '1',
                    'group' => 'services',
                    'description' => 'Toggle visibility for ' . str_replace(['service_', '_enabled'], '', $key)
                ]);
            }
        }

        $globalSettings = GlobalSetting::all()->groupBy('group');
        $markupSettings = MarkupSetting::all();
        $apiConfigs = \App\Models\ApiConfig::all();
        
        return view('admin.settings.index', compact('globalSettings', 'markupSettings', 'apiConfigs'));
    }

    public function updateServices(Request $request)
    {
        $serviceKeys = [
            'service_flights_enabled', 'service_hotels_enabled', 'service_flight_hotel_enabled',
            'service_homestays_enabled', 'service_cabs_enabled', 'service_trains_enabled',
            'service_holidays_enabled', 'service_visa_enabled', 'service_insurance_enabled',
            'service_esim_enabled', 'service_cargo_enabled', 'service_event_qr_enabled'
        ];

        foreach ($serviceKeys as $key) {
            $value = $request->has($key) ? '1' : '0';
            GlobalSetting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Service visibility updated successfully!');
    }

    public function updateGlobal(Request $request)
    {
        $settings = $request->input('settings', []);
        foreach ($settings as $key => $value) {
            GlobalSetting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Global settings updated successfully!');
    }

    public function updateMarkup(Request $request)
    {
        $markups = $request->input('markups', []);
        foreach ($markups as $id => $data) {
            MarkupSetting::where('id', $id)->update([
                'markup_type' => $data['type'],
                'markup_value' => $data['value'],
                'is_active' => isset($data['active'])
            ]);
        }

        return back()->with('success', 'Markup settings updated successfully!');
    }

    public function updateApiConfig(Request $request)
    {
        $configs = $request->input('configs', []);
        foreach ($configs as $id => $data) {
            \App\Models\ApiConfig::where('id', $id)->update([
                'is_active' => isset($data['active']),
                'priority' => $data['priority'] ?? 'secondary'
            ]);
        }

        return back()->with('success', 'API configurations updated successfully!');
    }
}
