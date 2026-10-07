<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProcurementCard;

class ProcurementCardSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['title' => 'Desktops & Workstations', 'tagline' => 'Reliable. High Performance. Office-Ready.', 'description' => 'Commercial HP, Dell, and Lenovo systems engineered for enterprise administrative and engineering performance.', 'image' => '/images/hardware/desktops.jpg', 'brands' => ['Dell', 'HP', 'Lenovo'], 'is_active' => true, 'sort_order' => 1],
            ['title' => 'Servers & Data Infrastructure', 'tagline' => 'High-Uptime. Redundant. Enterprise-Grade.', 'description' => 'Rackmount and tower server architectures, NAS storage systems, and enterprise data virtualization appliances.', 'image' => '/images/hardware/servers.jpg', 'brands' => ['Dell PowerEdge', 'HP ProLiant'], 'is_active' => true, 'sort_order' => 2],
            ['title' => 'CCTV & Surveillance Hardware', 'tagline' => 'Smart Detection. 24/7 Monitoring. High-Res.', 'description' => 'Hikvision IP cameras, network video recorders (NVRs), PTZ units, and biometric access control turnstiles.', 'image' => '/images/hardware/cctvsec.jpg', 'brands' => ['Hikvision'], 'is_active' => true, 'sort_order' => 3],
            ['title' => 'Networking & Fiber Optics', 'tagline' => 'High-Throughput. Managed. Resilient.', 'description' => 'Managed PoE switches, enterprise firewalls, core routers, fiber patch panels, and Dignity optical cables.', 'image' => '/images/hardware/fiber.jpg', 'brands' => ['Cisco', 'Fortinet', 'Dignity Fibre'], 'is_active' => true, 'sort_order' => 4],
            ['title' => 'Cybersecurity Solutions', 'tagline' => 'Advanced Threat Protection. Zero Trust.', 'description' => 'Next-generation firewalls, intrusion detection systems, and endpoint security platforms.', 'image' => '/images/hardware/cybersecurity.jpg', 'brands' => ['Fortinet', 'Cisco', 'Dell'], 'is_active' => true, 'sort_order' => 5],
        ];

        foreach($data as $item) { 
            ProcurementCard::create($item); 
        }
    }
}
