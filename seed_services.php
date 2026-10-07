<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$data = [
  ['icon' => 'Network', 'title' => 'Structured Cabling & Fiber Optics', 'tagline' => 'High-Speed Enterprise Backbones', 'description' => 'Cat6/6A copper infrastructure, optical fibre trunking, server rack cleanups, and patch panel terminations tested to Fluke enterprise standards.', 'highlights' => ['Multi-floor corporate backbones', 'Fibre splicing & OTDR testing', 'Rack cable management & labeling'], 'is_active' => true, 'sort_order' => 1],
  ['icon' => 'ShieldCheck', 'title' => 'Cybersecurity & Perimeter Defense', 'tagline' => 'Enterprise Threat Mitigation', 'description' => 'Next-generation Fortinet and Cisco firewall deployments, site-to-site VPN tunneling, intrusion prevention, and endpoint security compliance.', 'highlights' => ['Next-Gen firewall configuration', 'Zero Trust access controls', 'Vulnerability audits & mitigation'], 'is_active' => true, 'sort_order' => 2],
  ['icon' => 'PhoneCall', 'title' => 'PABX & IP Unified Communications', 'tagline' => 'Modern Corporate Telephony', 'description' => 'Modern IP-PBX systems, VoIP SIP trunks, multi-office interbranch calling, and integrated boardroom video conferencing solutions.', 'highlights' => ['Hybrid on-prem & cloud PBX', 'Boardroom conferencing AV', 'Interactive IVR & call routing'], 'is_active' => true, 'sort_order' => 3],
  ['icon' => 'Wrench', 'title' => 'SLA Support & IT Maintenance Contracts', 'tagline' => 'Guaranteed Operational Uptime', 'description' => 'Preventive and scheduled maintenance agreements ensuring minimal system downtime, rapid hardware replacement, and emergency engineer dispatch.', 'highlights' => ['Strict SLA response timelines', 'Scheduled preventive checkups', 'Emergency on-site troubleshooting'], 'is_active' => true, 'sort_order' => 4]
];

foreach($data as $item) { 
    \App\Models\Service::create($item); 
}
echo "Done!\n";
