<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@grandstartrealestate.com'],
            [
                'name' => 'Grand Start Admin',
                'password' => 'admin@2024',
                'active' => true,
            ]
        );
    }
}
