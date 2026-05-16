<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('translator', function ($translator, $app) {
            $trans = new \App\Translation\AutoSavingTranslator($translator->getLoader(), $translator->getLocale());
            $trans->setFallback($translator->getFallback());
            return $trans;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Illuminate\Pagination\Paginator::useBootstrap();

        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Dynamically override mail & Stripe config from database (admin panel)
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('global_settings')) {
                $settings = \App\Models\GlobalSetting::whereIn('group', ['smtp', 'payments'])
                    ->get()->pluck('value', 'key');

                // --- SMTP ---
                if ($settings->get('mail_host')) {
                    config([
                        'mail.mailers.smtp.host'       => $settings->get('mail_host'),
                        'mail.mailers.smtp.port'       => $settings->get('mail_port', 587),
                        'mail.mailers.smtp.username'   => $settings->get('mail_username'),
                        'mail.mailers.smtp.password'   => $settings->get('mail_password'),
                        'mail.mailers.smtp.encryption' => $settings->get('mail_encryption', 'tls'),
                        'mail.from.address'            => $settings->get('mail_from_address'),
                        'mail.from.name'               => $settings->get('mail_from_name'),
                    ]);
                }

                // --- Stripe Publishable Key (for frontend JS) ---
                if ($settings->get('payment_stripe_publishable_key')) {
                    config([
                        'services.stripe.key'    => $settings->get('payment_stripe_publishable_key'),
                        'services.stripe.secret' => $settings->get('payment_stripe_secret_key'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Silently fail during migrations/artisan commands
        }
    }
}
