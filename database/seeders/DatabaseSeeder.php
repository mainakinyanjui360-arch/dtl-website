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
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@dignityafrica.co.ke',
            'password' => Hash::make('password123'),
        ]);

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
    }
}
