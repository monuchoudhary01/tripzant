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
        $serviceKeys = [
            'service_flights_enabled', 'service_hotels_enabled', 'service_flight_hotel_enabled',
            'service_homestays_enabled', 'service_cabs_enabled', 'service_trains_enabled',
            'service_holidays_enabled', 'service_visa_enabled', 'service_insurance_enabled',
            'service_esim_enabled', 'service_cargo_enabled', 'service_event_qr_enabled'
        ];

        $paymentKeys = [
            'payment_stripe_enabled'           => '0',
            'payment_stripe_publishable_key'   => '',
            'payment_stripe_secret_key'        => '',
            'payment_mpgs_enabled'             => '0',
            'payment_mpgs_merchant_id'         => 'TESTEASIWORLDLKR',
            'payment_mpgs_api_password'        => '9af35b4d86d9186dddb216d1564c2375',
            'payment_mpgs_api_base_url'        => 'https://cbcmpgs.gateway.mastercard.com/api/rest/version/60',
            'payment_mpgs_currency'            => 'LKR',
            'payment_mpgs_test_mode'           => '0',
        ];

        foreach ($serviceKeys as $key) {
            if (!GlobalSetting::where('key', $key)->exists()) {
                GlobalSetting::create([
                    'key'         => $key,
                    'value'       => '1',
                    'group'       => 'services',
                    'description' => 'Toggle visibility for ' . str_replace(['service_', '_enabled'], '', $key)
                ]);
            }
        }

        foreach ($paymentKeys as $key => $defaultValue) {
            if (!GlobalSetting::where('key', $key)->exists()) {
                GlobalSetting::create([
                    'key'         => $key,
                    'value'       => $defaultValue,
                    'group'       => 'payments',
                    'description' => 'Configuration for ' . str_replace(['payment_', '_enabled'], '', $key)
                ]);
            }
        }

        $globalSettings = GlobalSetting::all()->groupBy('group');
        $markupSettings = MarkupSetting::all();
        $apiConfigs     = \App\Models\ApiConfig::all();

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
                'markup_type'  => $data['type'],
                'markup_value' => $data['value'],
                'is_active'    => isset($data['active'])
            ]);
        }

        return back()->with('success', 'Markup settings updated successfully!');
    }

    public function updateMarkups(Request $request)
    {
        $keys = ['default_b2c_markup', 'default_b2b_markup', 'default_corporate_markup', 'default_iata_markup'];
        foreach ($keys as $key) {
            GlobalSetting::updateOrCreate(
                ['key' => $key, 'group' => 'markup'],
                ['value' => $request->input($key, '0')]
            );
        }
        return back()->with('success', 'Default markups updated successfully!');
    }

    public function updateApiConfig(Request $request)
    {
        $configs = $request->input('configs', []);
        foreach ($configs as $id => $data) {
            \App\Models\ApiConfig::where('id', $id)->update([
                'is_active' => isset($data['active']),
                'priority'  => $data['priority'] ?? 'secondary'
            ]);
        }

        return back()->with('success', 'API configurations updated successfully!');
    }

    public function updateSmtp(Request $request)
    {
        $keys = ['mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name', 'mail_cc_address', 'mail_bcc_address'];
        foreach ($keys as $key) {
            GlobalSetting::updateOrCreate(
                ['key' => $key, 'group' => 'smtp'],
                ['value' => $request->input($key, '')]
            );
        }

        return back()->with('success', 'SMTP settings updated successfully!');
    }

    public function updateApiCredentials(Request $request)
    {
        $keys = [
            'amadeus_api_env', 'amadeus_api_key', 'amadeus_api_secret', 'amadeus_pcc_in',
            'amadeus_wsap_in', 'amadeus_user_in', 'amadeus_pass_in',
            'hotelbeds_api_key', 'hotelbeds_api_secret',
            'travelpayouts_token', 'travelpayouts_marker',
            'whatsapp_access_token', 'whatsapp_app_id',
        ];

        foreach ($keys as $key) {
            GlobalSetting::updateOrCreate(
                ['key' => $key, 'group' => 'api_credentials'],
                ['value' => $request->input($key, '')]
            );
        }

        // Handle whatsapp_access toggle
        GlobalSetting::updateOrCreate(
            ['key' => 'whatsapp_access', 'group' => 'api_credentials'],
            ['value' => $request->has('whatsapp_access') ? '1' : '0']
        );

        // Update ApiConfig active status
        $statuses  = $request->input('api_status', []);
        $providers = ['amadeus', 'hotelbeds', 'travelpayouts'];
        foreach ($providers as $provider) {
            \App\Models\ApiConfig::where('provider_name', $provider)->update([
                'is_active' => isset($statuses[$provider]) ? 1 : 0
            ]);
        }

        return back()->with('success', 'API Credentials updated successfully!');
    }

    public function updatePayments(Request $request)
    {
        $keys = [
            'payment_stripe_enabled', 'payment_stripe_publishable_key', 'payment_stripe_secret_key',
            'payment_mpgs_enabled', 'payment_mpgs_merchant_id', 'payment_mpgs_api_password',
            'payment_mpgs_api_base_url', 'payment_mpgs_currency', 'payment_mpgs_test_mode'
        ];

        foreach ($keys as $key) {
            if (strpos($key, '_enabled') !== false || strpos($key, '_mode') !== false) {
                $value = $request->has($key) ? '1' : '0';
            } else {
                $value = $request->input($key, '');
            }
            
            GlobalSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'payments']
            );
        }

        return back()->with('success', 'Payment gateway settings updated successfully!');
    }
}
