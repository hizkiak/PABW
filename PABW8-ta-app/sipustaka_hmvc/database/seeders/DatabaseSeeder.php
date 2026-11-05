<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => 'password',
                'role' => UserRole::Admin,
            ]
        );

        $this->call(\Modules\Buku\Database\Seeders\BukuDatabaseSeeder::class);

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Pengguna Biasa',
                'password' => 'password',
                'role' => UserRole::User,
            ]
        );
    }
}
