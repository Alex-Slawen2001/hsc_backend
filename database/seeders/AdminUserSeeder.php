<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hscopter.local'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin12345'),
                'is_admin' => 1,
            ]
        );
    }
}
