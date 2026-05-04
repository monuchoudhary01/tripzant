<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BankOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offers = [
            [
                'bank_name' => 'ICICI',
                'display_name' => 'ICICI BANK',
                'promo_code' => 'ICICIFEST',
                'tagline' => 'Get 10% OFF up to ₹1500 via ICICI Bank Cards.',
                'logo' => 'https://www.icicibank.com/favicon.ico',
                'color_code' => '#f37021',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'max_discount' => 1500,
                'min_amount' => 5000,
                'sort_order' => 1
            ],
            [
                'bank_name' => 'SBI',
                'display_name' => 'SBI BANK',
                'promo_code' => 'SBISAVER',
                'tagline' => 'Get 12% OFF up to ₹2000 via SBI Credit Cards.',
                'logo' => 'https://www.sbi.co.in/favicon.ico',
                'color_code' => '#00a1e3',
                'discount_type' => 'percentage',
                'discount_value' => 12,
                'max_discount' => 2000,
                'min_amount' => 7500,
                'sort_order' => 2
            ],
            [
                'bank_name' => 'HSBC',
                'display_name' => 'HSBC BANK',
                'promo_code' => 'HSBCFLAT',
                'tagline' => 'FLAT ₹1000 OFF via HSBC Bank Cards.',
                'logo' => 'https://www.hsbc.co.in/favicon.ico',
                'color_code' => '#db0011',
                'discount_type' => 'fixed',
                'discount_value' => 1000,
                'max_discount' => 1000,
                'min_amount' => 10000,
                'sort_order' => 3
            ],
            [
                'bank_name' => 'HDFC',
                'display_name' => 'HDFC BANK',
                'promo_code' => 'HDFCBANK',
                'tagline' => 'Get 15% OFF up to ₹2500 via HDFC Credit Cards.',
                'logo' => 'https://www.hdfcbank.com/favicon.ico',
                'color_code' => '#00367b',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'max_discount' => 2500,
                'min_amount' => 12000,
                'sort_order' => 4
            ],
            [
                'bank_name' => 'PNB',
                'display_name' => 'PNB BANK',
                'promo_code' => 'PNBSAVER',
                'tagline' => 'Get 8% OFF up to ₹1200 via PNB Bank Cards.',
                'logo' => 'https://www.pnbindia.in/favicon.ico',
                'color_code' => '#ed1c24',
                'discount_type' => 'percentage',
                'discount_value' => 8,
                'max_discount' => 1200,
                'min_amount' => 4000,
                'sort_order' => 5
            ],
        ];

        foreach ($offers as $offer) {
            \App\Models\BankOffer::updateOrCreate(['bank_name' => $offer['bank_name']], $offer);
        }
    }
}
