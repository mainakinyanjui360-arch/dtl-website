<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        // Override mail configuration with database settings if they exist
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $mailDriver = \App\Models\Setting::get('mail_driver');
                if ($mailDriver) {
                    config(['mail.default' => $mailDriver]);
                }

                $mailHost = \App\Models\Setting::get('mail_host');
                if ($mailHost) {
                    config([
                        'mail.mailers.smtp.host' => $mailHost,
                        'mail.mailers.smtp.port' => \App\Models\Setting::get('mail_port'),
                        'mail.mailers.smtp.username' => \App\Models\Setting::get('mail_username'),
                        'mail.mailers.smtp.password' => \App\Models\Setting::get('mail_password'),
                        'mail.mailers.smtp.encryption' => \App\Models\Setting::get('mail_encryption'),
                    ]);
                }
                
                $mailFromAddress = \App\Models\Setting::get('mail_from_address');
                if ($mailFromAddress) {
                    config([
                        'mail.from.address' => $mailFromAddress,
                        'mail.from.name' => \App\Models\Setting::get('mail_from_name'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Ignore during migrations or when DB is not available
        }
    }
}
