<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

\App\Models\Setting::set('contact_phone', '0722 000 000');
\App\Models\Setting::set('contact_email', 'sales@dignitytraders.co.ke');
\App\Models\Setting::set('contact_address', 'Nairobi, Kenya');

echo "Done!\n";
