<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\GlobalSetting;
use App\Models\MarkupSetting;

class SystemSettingsSeeder extends Seeder
{
    public function run()
    {
        // Global Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Tripzant', 'group' => 'general', 'description' => 'Main application name'],
            ['key' => 'contact_email', 'value' => 'support@tripzant.com', 'group' => 'general', 'description' => 'Support email address'],
            ['key' => 'currency_symbol', 'value' => '₹', 'group' => 'general', 'description' => 'Default currency symbol'],
        ];

        foreach ($settings as $s) {
            GlobalSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // Default Markups
        $markups = [
            ['module' => 'flight', 'user_role' => 'b2c', 'markup_type' => 'percent', 'markup_value' => '10.00'],
            ['module' => 'flight', 'user_role' => 'b2b_agent', 'markup_type' => 'percent', 'markup_value' => '2.00'],
            ['module' => 'hotel', 'user_role' => 'b2c', 'markup_type' => 'percent', 'markup_value' => '15.00'],
            ['module' => 'esim', 'user_role' => 'b2c', 'markup_type' => 'percent', 'markup_value' => '20.00'],
            ['module' => 'insurance', 'user_role' => 'b2c', 'markup_type' => 'percent', 'markup_value' => '25.00'],
            ['module' => 'tour', 'user_role' => 'b2c', 'markup_type' => 'percent', 'markup_value' => '12.00'],
        ];

        foreach ($markups as $m) {
            MarkupSetting::updateOrCreate(['module' => $m['module'], 'user_role' => $m['user_role']], $m);
        }
    }
}
