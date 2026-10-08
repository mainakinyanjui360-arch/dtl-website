<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@dignityafrica.co.ke'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'is_super_admin' => true,
            ]
        );

        // 2. Seed Default Categories
        $categories = [
            'Fiber Optic Products',
            'ICT Hardware',
            'PABX & IP Phones',
            'Professional AV',
            'Security Products',
            'Uncategorized'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }

        $this->call([
            ProcurementCardSeeder::class,
            ProjectSeeder::class,
            ServiceSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
