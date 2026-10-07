<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$projects = [
    [
        'title' => 'Enterprise Network Infrastructure Upgrade',
        'client' => 'National Bank Headquarters',
        'description' => 'Complete overhaul of the core networking infrastructure spanning 12 floors. Deployed Cat6A structured cabling, Cisco Nexus switches, and upgraded the fiber optic backbone to support 10G speeds across all departments. The project was completed over a weekend with zero downtime to banking operations.',
        'category' => 'Structured Cabling',
        'completion_date' => '2025-08-15',
        'is_active' => true,
        'sort_order' => 1
    ],
    [
        'title' => 'Data Center Fortinet Firewall Deployment',
        'client' => 'Ministry of Trade',
        'description' => 'Implemented a high-availability (HA) cluster of FortiGate Next-Generation Firewalls at the central data center. The solution included site-to-site VPNs connecting 15 regional offices, zero-trust network access (ZTNA), and comprehensive endpoint security for over 2,000 devices.',
        'category' => 'Cybersecurity',
        'completion_date' => '2025-11-22',
        'is_active' => true,
        'sort_order' => 2
    ],
    [
        'title' => 'Unified Communications VoIP Rollout',
        'client' => 'Safaricom Regional Office',
        'description' => 'Replaced legacy analog PABX with a modern IP telephony system supporting 500+ extensions. Integrated boardroom video conferencing hardware, interactive voice response (IVR), and call recording features to improve customer service workflows.',
        'category' => 'IP Telephony',
        'completion_date' => '2026-02-10',
        'is_active' => true,
        'sort_order' => 3
    ]
];

foreach ($projects as $proj) {
    \App\Models\Project::create($proj);
}

echo "Seeded projects successfully!\n";
