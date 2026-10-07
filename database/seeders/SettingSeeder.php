<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('contact_phone', '0722 000 000');
        Setting::set('contact_email', 'sales@dignitytraders.co.ke');
        Setting::set('contact_address', 'Nairobi, Kenya');
    }
}
