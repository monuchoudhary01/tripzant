<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServicePlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insurance Plans
        \App\Models\InsurancePlan::updateOrCreate(['name' => '$250k + OPD Travel Insurance'], [
            'provider' => 'TATA AIG General Insurance Company Ltd',
            'provider_logo' => 'https://www.tataaig.com/favicon.ico',
            'price' => 396.00,
            'old_price' => 559.00,
            'sum_insured' => '$250,000',
            'benefits' => json_encode(['Medical Expenses up to $250k', 'Trip Cancellation $500', 'Baggage Loss $500']),
            'type' => 'International',
            'is_recommended' => true
        ]);

        \App\Models\InsurancePlan::updateOrCreate(['name' => '$50k Silver Protection'], [
            'provider' => 'HDFC ERGO General Insurance',
            'provider_logo' => 'https://www.hdfcergo.com/favicon.ico',
            'price' => 210.00,
            'old_price' => 280.00,
            'sum_insured' => '$50,000',
            'benefits' => json_encode(['Medical Expenses up to $50k', 'Trip Cancellation $250', 'Baggage Loss $300']),
            'type' => 'International',
            'is_recommended' => false
        ]);

        // eSIM Plans
        \App\Models\EsimPlan::updateOrCreate(['region' => 'United Arab Emirates'], [
            'country_code' => 'ae',
            'data_amount' => '5GB',
            'validity_days' => 7,
            'price' => 12.50,
            'network' => 'Etisalat/Du'
        ]);

        \App\Models\EsimPlan::updateOrCreate(['region' => 'Europe (35 Countries)'], [
            'country_code' => 'eu',
            'data_amount' => '10GB',
            'validity_days' => 30,
            'price' => 35.00,
            'network' => 'Orange/Vodafone'
        ]);

        \App\Models\EsimPlan::updateOrCreate(['region' => 'United States'], [
            'country_code' => 'us',
            'data_amount' => 'Unlimited',
            'validity_days' => 15,
            'price' => 28.90,
            'network' => 'T-Mobile/AT&T'
        ]);

        \App\Models\EsimPlan::updateOrCreate(['region' => 'India'], [
            'country_code' => 'in',
            'data_amount' => '5GB',
            'validity_days' => 15,
            'price' => 8.50,
            'network' => 'Jio/Airtel'
        ]);
    }
}
