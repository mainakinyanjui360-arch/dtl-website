<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the latest USD to KES exchange rate and updates settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching latest exchange rates...');

        // Check if auto-update is enabled
        $autoUpdate = Setting::where('key', 'auto_update_exchange_rate')->value('value');
        if ($autoUpdate === 'false' || $autoUpdate === '0') {
            $this->warn('Auto-update is disabled in settings. Skipping.');
            return;
        }

        try {
            // Using a free open API that doesn't require an API key
            $response = Http::get('https://open.er-api.com/v6/latest/USD');

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['rates']['KES'])) {
                    $rate = $data['rates']['KES'];
                    
                    // Update or create setting
                    Setting::updateOrCreate(
                        ['key' => 'exchange_rate_usd_to_kes'],
                        ['value' => $rate, 'type' => 'number']
                    );
                    
                    $this->info("Successfully updated USD to KES rate: {$rate}");
                } else {
                    $this->error('KES rate not found in API response.');
                }
            } else {
                $this->error('Failed to fetch data from ExchangeRate-API.');
            }
        } catch (\Exception $e) {
            $this->error('Error occurred: ' . $e->getMessage());
        }
    }
}
