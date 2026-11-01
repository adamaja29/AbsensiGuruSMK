<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Sekolah',
                'email' => 'admin@gmail.com',
                'password' => '12345678',
                'role' => 'admin',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'guru@gmail.com',
                'password' => '12345678',
                'role' => 'guru',
            ],
            [
                'name' => 'Waka Kurikulum',
                'email' => 'waka@gmail.com',
                'password' => '12345678',
                'role' => 'waka',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}

